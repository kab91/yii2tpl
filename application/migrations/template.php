<?php
echo "<?php\n";
?>

use yii\db\Schema;
use yii\db\Migration;

class <?= $className ?> extends Migration
{
    public function up()
    {
	$sql = <<<SQL

SQL;
    	$connection = Yii::$app->db; 
  	
    	$command = $connection->createCommand($sql);
    	$command -> execute();
    }

    public function down()
    {
        echo "<?= $className ?> cannot be reverted.\n";

        return false;
    }
}
