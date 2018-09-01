<?php
namespace App\Validation;

use Rakit\Validation\Rule;
use Illuminate\Database\Capsule\Manager as Capsule;

class UniqueRule extends Rule
{
    protected $message = ":attribute :value has been used";
    protected $fillable_params = ['table', 'column', 'except'];
    protected $pdo;

    public function __construct()
    {
        $this->pdo = Capsule::connection()->getPdo();
    }

    public function check($value)
    {
        // make sure required parameters exists
        $this->requireParameters(['table', 'column']);
    
        // getting parameters
        $column = $this->parameter('column');
        $table = $this->parameter('table');
        $except = $this->parameter('except');
        
        if ($except and $except == $value) {
            return true;
        }
	
        // do query
        $stmt = $this->pdo->prepare("select count(*) as count from `{$table}` where `{$column}` = :value");
        $stmt->bindParam(':value', $value);
        $stmt->execute();
        $data = $stmt->fetch(\PDO::FETCH_ASSOC);
	
        // true for valid, false for invalid
        return intval($data['count']) === 0;
    }
}