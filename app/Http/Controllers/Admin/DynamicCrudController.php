<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class DynamicCrudController extends Controller
{
    public function create()
    {
        return view('pages.dynamic-crud.dynamic_crud');
    }

    public function store(Request $request)
    {
        $request->validate([
            'table_name' => 'required|string|max:255',
            'columns' => 'required|array|min:1',
            'columns.*.name' => 'required|string|max:255',
            'columns.*.type' => 'required|string',
        ]);

        $tableName = Str::snake($request->input('table_name'));
        $columns = $request->input('columns');

        // Generate migration
        $migrationName = 'create_' . $tableName . '_table';
        $migrationPath = database_path('migrations/' . date('Y_m_d_His') . '_' . $migrationName . '.php');
        $migrationContent = $this->generateMigration($tableName, $columns);
        file_put_contents($migrationPath, $migrationContent);

        // Run migration
        Artisan::call('migrate');

        // Generate model
        $this->generateModel($tableName, $columns);

        // Generate controller
        $this->generateController($tableName, $columns);

        // Generate views
        $this->generateViews($tableName, $columns);

        // Generate resource route in web.php
        $this->addResourceRoute($tableName);

        return redirect()->route('dynamic.crud.create')->with('success', 'CRUD created successfully!');
    }

    private function generateMigration($tableName, $columns)
    {
        $columnsString = '';
        foreach ($columns as $column) {
            $type = $column['type'];
            $name = $column['name'];
            $nullable = isset($column['nullable']) && $column['nullable'] ? '->nullable()' : '';

            $columnsString .= "\$table->{$type}('{$name}'){$nullable};\n            ";
        }

        return "<?php\nuse Illuminate\Database\Migrations\Migration;\nuse Illuminate\Database\Schema\Blueprint;\nuse Illuminate\Support\Facades\Schema;\n\nclass Create" . ucfirst($tableName) . "Table extends Migration\n{\n    public function up()\n    {\n        Schema::create('$tableName', function (Blueprint \$table) {\n            \$table->id();\n            $columnsString\n            \$table->timestamps();\n        });\n    }\n\n    public function down()\n    {\n        Schema::dropIfExists('$tableName');\n    }\n}\n";
    }

    private function generateModel($tableName, $columns)
    {
        $fillableFields = array_column($columns, 'name');
        $modelContent = "<?php\nnamespace App\Models;\n\nuse Illuminate\Database\Eloquent\Factories\HasFactory;\nuse Illuminate\Database\Eloquent\Model;\n\nclass " . ucfirst($tableName) . " extends Model\n{\n    use HasFactory;\n    protected \$table = '$tableName';\n    protected \$fillable = ['" . implode("', '", $fillableFields) . "'];\n}\n";
        file_put_contents(app_path("Models/" . ucfirst($tableName) . ".php"), $modelContent);
    }

    private function generateController($tableName, $columns)
    {
        $controllerName = ucfirst($tableName) . "Controller";
        $controllerPath = app_path("Http/Controllers/Admin/{$controllerName}.php");

        $storeFields = '';
        $updateFields = '';
        $validationRules = '';

        foreach ($columns as $column) {
            $storeFields .= "'{$column['name']}' => \$request->input('{$column['name']}'),\n            ";
            $updateFields .= "'{$column['name']}' => \$request->input('{$column['name']}'),\n            ";
            $validationRules .= "'{$column['name']}' => 'required',\n            ";
        }

        $controllerContent = "<?php\n\nnamespace App\Http\Controllers\Admin;\n\nuse App\Http\Controllers\Controller;\nuse Illuminate\Http\Request;\nuse App\Models\\" . ucfirst($tableName) . ";\n\nclass {$controllerName} extends Controller\n{\n
        public function index()\n    {\n        \$items = " . ucfirst($tableName) . "::all();\n        return view('pages." . strtolower($tableName) . ".index', compact('items'));\n    }\n\n
        public function create()\n    {\n        return view('pages." . strtolower($tableName) . ".create');\n    }\n\n
        public function store(Request \$request)\n    {\n        \$request->validate([\n            $validationRules\n        ]);\n\n        \$data = [\n            $storeFields\n        ];\n\n
        " . ucfirst($tableName) . "::create(\$data);\n\n        return redirect()->route('" . strtolower($tableName) . ".index')->with('success', 'Record created successfully.');\n    }\n\n
        public function edit(\$id)\n    {\n        \$item = " . ucfirst($tableName) . "::findOrFail(\$id);\n        return view('pages." . strtolower($tableName) . ".edit', compact('item'));\n    }\n\n
        public function update(Request \$request, \$id)\n    {\n        \$request->validate([\n            $validationRules\n        ]);\n\n        \$data = [\n            $updateFields\n        ];\n\n
        \$item = " . ucfirst($tableName) . "::findOrFail(\$id);\n        \$item->update(\$data);\n\n        return redirect()->route('" . strtolower($tableName) . ".index')->with('success', 'Record updated successfully.');\n    }\n\n
        public function destroy(\$id)\n    {\n        \$item = " . ucfirst($tableName) . "::findOrFail(\$id);\n        \$item->delete();\n\n
        return redirect()->route('" . strtolower($tableName) . ".index')->with('success', 'Record deleted successfully.');\n    }\n}\n";

        file_put_contents($controllerPath, $controllerContent);
    }

    private function generateViews($tableName, $columns)
    {
        $viewsPath = resource_path("views/pages/" . strtolower($tableName));
        if (!is_dir($viewsPath)) {
            mkdir($viewsPath, 0755, true);
        }

        $indexContent = $this->generateIndexView($tableName, $columns);
        file_put_contents($viewsPath . '/index.blade.php', $indexContent);

        $createContent = $this->generateCreateView($tableName, $columns);
        file_put_contents($viewsPath . '/create.blade.php', $createContent);

        $editContent = $this->generateEditView($tableName, $columns);
        file_put_contents($viewsPath . '/edit.blade.php', $editContent);
    }
    private function generateIndexView($tableName, $columns)
    {
        $headers = '';
        $data = '';
    
        foreach ($columns as $column) {
            $headers .= "<th>" . ucfirst($column['name']) . "</th>\n";
    
            if (isset($column['html_type']) && $column['html_type'] == 'file') {
                $data .= "
                    @php
                        // Get file extension
                        \$fileExtension = pathinfo(\$item->{$column['name']}, PATHINFO_EXTENSION);
                        
                        // Determine file type
                        \$isImage = in_array(\$fileExtension, ['jpg', 'jpeg', 'png', 'gif']);
                        \$isVideo = in_array(\$fileExtension, ['mp4', 'webm', 'ogg']);
                    @endphp
                ";
    
                $data .= "
                    @if(\$isImage)
                        <td><img src=\"{{ \$item->{$column['name']} }}\" style=\"height: 50px; object-fit: cover;\" /></td>
                    @elseif(\$isVideo)
                        <td>
                            <video width=\"100\" height=\"50\" controls>
                                <source src=\"{{ \$item->{$column['name']} }}\" type=\"video/{{ \$fileExtension }}\">
                                Your browser does not support the video tag.
                            </video>
                        </td>
                    @else
                        <td>{{ \$item->{$column['name']} }}</td>
                    @endif
                ";
            } else {
                // Default to normal text for any other type (e.g. text, URL)
                $data .= "<td>{{ \$item->{$column['name']} }}</td>\n";
            }
        }
    
        return "@extends('layouts.main')\n\n@section('content')\n<div class=\"container\">\n
        <h2>" . ucfirst($tableName) . " Records</h2>\n
        <a href=\"{{ route('" . strtolower($tableName) . ".create') }}\" class=\"btn btn-primary\">Create New</a>\n
        <table class=\"table table-bordered\">\n
        <thead>\n<tr>\n<th>ID</th>\n$headers<th>Actions</th>\n</tr>\n</thead>\n<tbody>\n
        @foreach(\$items as \$item)\n<tr>\n
        <td>{{ \$item->id }}</td>\n$data<td>\n
        <a href=\"{{ route('" . strtolower($tableName) . ".edit', \$item->id) }}\" class=\"btn btn-info\">Edit</a>\n
        <button class=\"btn btn-danger deleteItem\" data-id=\"{{ \$item->id }}\">Delete</button>\n
        </td>\n</tr>\n@endforeach\n</tbody>\n</table>\n
        </div>\n@endsection\n
        @push('script')\n
        <script>

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name=\"csrf-token\"]').attr('content')
            }
        });


            $('body').on('click', '.deleteItem', function () {
                var item_id = $(this).data(\"id\");
                swal({
                    title: `Are you sure you want to delete this record?`,
                    text: \"If you delete this, it will be gone forever.\",
                    icon: \"warning\",
                    buttons: true,
                    dangerMode: true,
                }).then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            type: \"DELETE\",
                            url: \"{{ url('admin/" . strtolower($tableName) . "') }}\" + '/' + item_id,
                            success: function (data) {
                                // Reload the table or remove the row
                                location.reload(); // Option 1: Reload page
                                // Option 2: Remove row without reload
                                // $('tr[data-id=\"' + item_id + '\"]').remove();
                                toastr.options.timeOut = 5000;
                                toastr.success(\"Record has been deleted\");
                            },
                            error: function (response) {
                                toastr.options.timeOut = 5000;
                                toastr.success(\"Record has been deleted\");
                                location.reload(); 
                            }
                        });
                    }
                });
            });
        </script>\n
        @endpush";
    }
    


    private function generateCreateView($tableName, $columns) {
        $formFields = '';

        foreach ($columns as $column) {
            switch ($column['html_type']) {
                case 'textarea':
                    $formFields .= "<div class=\"form-group row\">\n";
                    $formFields .= "    <label for=\"{$column['name']}\" class=\"col-sm-2 col-form-label\">" . ucfirst($column['name']) . "</label>\n";
                    $formFields .= "    <div class=\"col-sm-10\">\n";
                    $formFields .= "        <x-ckeditor name=\"{$column['name']}\" id=\"{$column['name']}\" :value=\"null\" />\n";
                    $formFields .= "    </div>\n";
                    $formFields .= "</div>\n";
                    break;
                case 'file': // Handle file input
                    $formFields .= "<div class=\"form-group row\">\n";
                    $formFields .= "    <label for=\"{$column['name']}\" class=\"col-sm-2 col-form-label\">" . ucfirst($column['name']) . "</label>\n";
                    $formFields .= "    <div class=\"col-sm-10\">\n";
                    $formFields .= "        <x-image-input name=\"{$column['name']}\" columns=\"col-md-12\" value=\"\" id=\"{$column['name']}\" label=\"" . ucfirst($column['name']) . "\" />\n";
                    $formFields .= "    </div>\n";
                    $formFields .= "</div>\n";
                    break;
                default: // Default to text input for other types
                    $formFields .= "<div class=\"form-group row\">\n";
                    $formFields .= "    <label for=\"{$column['name']}\" class=\"col-sm-2 col-form-label\">" . ucfirst($column['name']) . "</label>\n";
                    $formFields .= "    <div class=\"col-sm-10\">\n";
                    $formFields .= "        <input type=\"text\" name=\"{$column['name']}\" id=\"{$column['name']}\" class=\"form-control\" />\n";
                    $formFields .= "    </div>\n";
                    $formFields .= "</div>\n";
                    break;
            }
        }

        return "@extends('layouts.main')\n\n@section('content')\n<div class=\"container\">\n    <h2 class=\"mb-4\">Create New " . ucfirst($tableName) . "</h2>\n
        <form method=\"POST\" action=\"{{ route('" . strtolower($tableName) . ".store') }}\" enctype=\"multipart/form-data\">\n        @csrf\n        $formFields\n        <div class=\"form-group row\">\n
            <div class=\"col-sm-10 offset-sm-2\">\n<button type=\"submit\" class=\"btn btn-success\">Submit</button>\n
            </div></div>\n</form>\n</div>\n@endsection";
    }

    
    private function generateEditView($tableName, $columns) {
        $formFields = '';

        foreach ($columns as $column) {
            switch ($column['html_type']) {
                case 'textarea':
                    $formFields .= "<div class=\"form-group row\">\n";
                    $formFields .= "    <label for=\"{$column['name']}\" class=\"col-sm-2 col-form-label\">" . ucfirst($column['name']) . "</label>\n";
                    $formFields .= "    <div class=\"col-sm-10\">\n";
                    $formFields .= "        <x-ckeditor name=\"{$column['name']}\" id=\"{$column['name']}\" :value=\"\$item->{$column['name']}\" />\n";
                    $formFields .= "    </div>\n";
                    $formFields .= "</div>\n";
                    break;
                case 'file': // Handle file input with preview for existing files
                    $formFields .= "<div class=\"form-group row\">\n";
                    $formFields .= "    <label for=\"{$column['name']}\" class=\"col-sm-2 col-form-label\">" . ucfirst($column['name']) . "</label>\n";
                    $formFields .= "    <div class=\"col-sm-10\">\n";
                    $formFields .= "        <x-image-input name=\"{$column['name']}\" columns=\"col-md-12\" value=\"{{ \$item->{$column['name']} }}\" id=\"{$column['name']}\" label=\"" . ucfirst($column['name']) . "\" />\n";
                    $formFields .= "    </div>\n";
                    $formFields .= "</div>\n";
                    break;
                default: // Default to text input for other types
                    $formFields .= "<div class=\"form-group row\">\n";
                    $formFields .= "    <label for=\"{$column['name']}\" class=\"col-sm-2 col-form-label\">" . ucfirst($column['name']) . "</label>\n";
                    $formFields .= "    <div class=\"col-sm-10\">\n";
                    $formFields .= "        <input type=\"text\" name=\"{$column['name']}\" id=\"{$column['name']}\" class=\"form-control\" value=\"{{ \$item->{$column['name']} }}\" />\n";
                    $formFields .= "    </div>\n";
                    $formFields .= "</div>\n";
                    break;
            }
        }

        return "@extends('layouts.main')\n\n@section('content')\n<div class=\"container\">\n    <h2 class=\"mb-4\">Edit " . ucfirst($tableName) . "</h2>\n
        <form method=\"POST\" action=\"{{ route('" . strtolower($tableName) . ".update', \$item->id) }}\" enctype=\"multipart/form-data\">\n        @csrf\n        @method('PUT')\n        $formFields\n
            <div class=\"form-group row\">\n<div class=\"col-sm-10 offset-sm-2\">\n<button type=\"submit\" class=\"btn btn-success\">Submit</button>\n
            </div></div>\n</form>\n</div>\n@endsection";
    }

    
    private function addResourceRoute($tableName)
    {
        $webFile = base_path('routes/web.php');
        $resourceRoute = "\nRoute::resource('" . strtolower($tableName) . "', Admin\\" . ucfirst($tableName) . "Controller::class);";

        file_put_contents($webFile, $resourceRoute, FILE_APPEND);
    }
}
