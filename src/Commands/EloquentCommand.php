<?php
namespace Multt\Generators\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\DB;
use Multt\Generators\Template;

class EloquentCommand extends Command
{

    protected $fs;

    protected $signature = 'multt:eloquent {--namespace=App\Eloquent : Namespace}';

    protected $description = 'Generates a Eloquent class based on Database';

    public function __construct(Filesystem $fs)
    {
        parent::__construct();
        $this->fs = $fs;
    }

    public function handle()
    {
        $namespace = $this->option('namespace');
        
        $dbName = DB::getDatabaseName();
        $sql = "select distinct table_name from information_schema.columns where table_schema=:dbname";
        $tables = DB::select($sql, [
            "dbname" => $dbName
        ]);
        
        $filename = __DIR__ . "/../Templates/eloquent.tpl";
        
        $tpl = new Template($filename);
        
        $ncount = 0;
        foreach ($tables as $table) {
            $table->table_name;
            $sql_table = "select column_name from information_schema.columns 
            	where table_schema=:dbname and table_name=:tablename and column_key='PRI'";
            $sqlParam = [
                "dbname" => $dbName,
                "tablename" => $table->table_name
            ];
            
            $pks = DB::selectOne($sql_table, $sqlParam);
            
            $table_name_ORM = str_replace('_', '', ucwords($table->table_name, "_")) . "ORM";
            
            $tpl->clear();
            $tpl->set("namespace", str_replace("/", "\\", $namespace));
            $tpl->set("table_name_ORM", $table_name_ORM);
            $tpl->set("table_name", $table->table_name);
            $tpl->set("pks_column_name", $pks->column_name);
            $content = $tpl->render();
            
            $savePath = "./" . str_replace("\\", "/", $namespace) . "/$table_name_ORM.php";
            // echo "$savePath\n";
            $this->makeDirectory($savePath);
            $this->fs->put($savePath, $content);
            echo "Generated... [$savePath]\n";
            $ncount ++;
        }
        
        echo "Total: $ncount files.\n";
    }

    protected function makeDirectory($path)
    {
        if (! $this->fs->isDirectory(dirname($path))) {
            $this->fs->makeDirectory(dirname($path), 0777, true, true);
        }
    }
}
