<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use Mindy\Orm\Fields\AutoField;
use Mindy\Orm\Fields\BooleanField;
use Mindy\Orm\Fields\CharField;
use Mindy\Orm\Fields\DateTimeField;
use Mindy\Orm\Fields\FloatField;
use Mindy\Orm\Fields\IntField;
use Mindy\Orm\Fields\TextField;
use Mindy\Orm\Model;
use Mindy\Orm\Sync;
use Mindy\Query\Connection;

Model::setConnection(new Connection([
    'dsn' => 'mysql:host=localhost;dbname=dja_db',
    'username' => 'root',
    'password' => '123456',
    'charset' => 'utf8',
]));

class CustomerOrder extends Model
{
    public static function tableName()
    {
        return 'customer_order';
    }

    public function getFields()
    {
        return [
            'customer_order_id' => [

                'class' => AutoField::className(),
                'help_text' => 'первичный ключ'
            ],
            'date_added' => [
                'class' => DateTimeField::className(),
                'null' => true,
                'verboseName' => 'время создания'
            ],
            'delivery_price' => [
                'class' => FloatField::className(),
                'null' => true,
                'default' => '0',
                'verboseName' => 'стоимость доставки'
            ],
            'delivery_date' => [
                'class' => DateTimeField::className(),
                'null' => true,
                'verboseName' => 'дата доставки'
            ],
            'comment' => [
                'class' => TextField::className(),
                'required' => false,
                'verboseName' => 'комментарий'
            ],
            'pre_weight' => [
                'class' => FloatField::className(),
                'null' => true,
                'verboseName' => 'Вес, кг. Кэш'
            ],
            'pre_length' => [
                'class' => FloatField::className(),
                'null' => true,
                'verboseName' => 'ширина, см. Кэш'
            ],
            'pre_width' => [
                'class' => FloatField::className(),
                'null' => true,
                'verboseName' => 'глубина, см. Кэш'
            ],
            'pre_height' => [
                'class' => FloatField::className(),
                'null' => true,
                'verboseName' => 'высота, см. Кэш'
            ],
            'pre_price' => [
                'class' => FloatField::className(),
                'default' => '0',
                'verboseName' => 'стоимость всех товаров в заказе без стоимости доставки. кэш'
            ],
//            'user' => [
//                'ForeignKey',
//                'relationClass' => 'ModelUser',
//                'db_column' => 'user_id',
//                'null' => true,
//                'verboseName' => 'ссылка на ответственного менеджера БО'
//            ],
            'address' => [
                'class' => TextField::className(),
                'required' => false,
                'verboseName' => 'адрес доставки. JSON-массивArray(    [address] => 190005, Санкт-Петербург , Советский пер, дом 1    [kladr] => 1780000000001307    [params] => Array        (            [postcode] => 190005            [house] => 1            [korp] =>             [str] =>             [apart] =>             [ajaxCity] => Санкт-Петербург            [ajaxStreet] => Советский пер            [hidden_postcode] =>         ))'],
            'stock_order_number' => [
                'class' => IntField::className(),
                'null' => true,
                'verboseName' => 'номер заказа на объекте'
            ],
            'order_number' => [
                'class' => CharField::className(),
                'null' => true,
                'length' => 21,
                'default' => '',
                'required' => false,
                'verboseName' => 'полный номер заказа'
            ],
//            'workflow_status' => [
//                'ForeignKey',
//                'relationClass' => 'ModelWorkflowStatus',
//                'db_column' => 'workflow_status_id',
//                'null' => true,
//                'verboseName' => 'статус документооборота'
//            ],
            'workflow_status' => [
                'class' => IntField::className(),
                'null' => true,
                'verboseName' => 'статус документооборота'
            ],
            'passport' => [
                'class' => TextField::className(),
                'required' => false,
                'verboseName' => 'Паспортные данные. JSON-массив (ФИО - fio, серия паспорта - series, номер паспорта - number, кем выдан - police, дата выдачи - date)'
            ],
            'is_cc_sent' => [
                'class' => BooleanField::className(),
                'default' => true,
                'verboseName' => 'Отправлен ли в КЦ (call-center)?'
            ],
            'workflow_date_edit' => [
                'class' => DateTimeField::className(),
                'null' => true,
                'verboseName' => 'Дата последнего WF-перехода'
            ],
            'box_count' => [
                'class' => IntField::className(),
                'default' => 0,
                'verboseName' => 'Количество коробок, в которое упакован заказ'
            ],
//            'workflow_status_reason' => [
//                'ForeignKey',
//                'relationClass' => 'ModelWorkflowStatusReason',
//                'db_column' => 'workflow_status_reason_id',
//                'null' => true,
//                'verboseName' => 'Причина установки статуса'
//            ],
            'workflow_status_reason' => [
                'class' => IntField::className(),
                'null' => true,
                'verboseName' => 'Причина установки статуса'
            ],
            'date_modified' => [
                'class' => DateTimeField::className(),
                'null' => true,
                'verboseName' => 'Дата последнего изменения'
            ],
            'customer_name' => [
                'class' => CharField::className(),
                'default' => '',
                'required' => false,
                'verboseName' => 'имя покупателя'
            ],
            'has_act' => [
                'class' => BooleanField::className(),
                'default' => true,
                'verboseName' => 'есть ли акт сдачи-приемки товаров?'
            ],
            'ip' => [
                'class' => CharField::className(),
                'null' => true,
                'verboseName' => 'IP-адрес покупателя'
            ],
            'delivery_full_price' => [
                'class' => FloatField::className(),
                'null' => true,
                'default' => '0',
                'verboseName' => 'стоимость доставки без учёта скидки'
            ],
            'linked_customer_orders' => [
                'class' => CharField::className(),
                'null' => true,
                'length' => 200,
                'verboseName' => 'Связанные заказы'
            ],
            'claims' => [
                'class' => CharField::className(),
                'null' => true,
                'length' => 200,
                'verboseName' => 'Претензии'
            ],
            'service_comment' => [
                'class' => TextField::className(),
                'required' => false,
                'verboseName' => 'служебный комментарий'
            ],
            'pre_full_price' => [
                'class' => FloatField::className(),
                'null' => true,
                'verboseName' => 'Оценочная стоимость заказа'
            ],
            'index_number' => [
                'class' => IntField::className(),
                'null' => true,
                'verboseName' => 'Порядковый номер заказа'
            ],
        ];
    }
}

function formatBytes($size)
{
    $filesizename = array(" Bytes", " KB", " MB", " GB", " TB", " PB", " EB", " ZB", " YB");
    return $size ? round($size / pow(1024, ($i = floor(log($size, 1024)))), 2) . $filesizename[$i] : '0 Bytes';
}

function result($d1, $t1, $t2)
{
    echo 'delta: ' . formatBytes($d1) . PHP_EOL;
    echo 'exec in ' . round(($t2 - $t1), 3) . ' s' . PHP_EOL;
    echo 'peak: ' . formatBytes(memory_get_peak_usage(1)) . PHP_EOL;
}

function testBigSelectArray($limit)
{
    $t1 = microtime(1);
    $m1 = memory_get_usage(1);
    $raw = CustomerOrder::objects()->paginate(1, $limit)->asArray()->all();
    foreach ($raw as $i => &$row) {

    }
    result(memory_get_usage(1) - $m1, $t1, microtime(1));
}

function testBigSelectObj($limit)
{
    $t1 = microtime(1);
    $m1 = memory_get_usage(1);
    $q = CustomerOrder::objects()->paginate(1, $limit)->all(); //->selectRelated('stock', 'customer'); //->noCache();
    $ids = [];
    foreach ($q as $i => $row) {
        $ids[] = $row->customer_order_id;
        $tmp = $row->workflow_status;
        //$row->workflow_status_id = 1; // overhead for cleanData copy
        //if ($i > 2000) break;
    }
    echo "uniques: " . count(array_unique($ids)) . PHP_EOL;
    unset($ids);
    result(memory_get_usage(1) - $m1, $t1, microtime(1));
}

$sync = new Sync([new CustomerOrder]);
$sync->create();

$params = $argv;
unset($params[0]);
$command = array_shift($params);
$limit = count($params) > 0 ? $params[0] : 10000;

switch($command) {
    case 'create':
        foreach(range(1, 20000) as $i) {
            CustomerOrder::objects()->getOrCreate([
                'customer_order_id' => $i,
                'date_added' => time(),
                'delivery_price' => $i,
                'delivery_date' => time(),
                'comment' => $i,
                'pre_weight' => $i,
                'pre_length' => $i,
                'pre_width' => $i,
                'pre_height' => $i,
                'pre_price' => $i,
                'address' => $i,
                'stock_order_number' => $i,
                'order_number' => $i,
                'workflow_status' => $i,
                'passport' => $i,
                'is_cc_sent' => $i,
                'workflow_date_edit' => time(),
                'box_count' => $i,
                'workflow_status_reason' => $i,
                'date_modified' => time(),
                'customer_name' => $i,
                'has_act' => $i,
                'ip' => $i,
                'delivery_full_price' => $i,
                'linked_customer_orders' => $i,
                'claims' => $i,
                'service_comment' => $i,
                'pre_full_price' => $i,
                'index_number' => $i,
            ]);
            gc_collect_cycles();
            echo $i . PHP_EOL;
        }
        echo "Total: " . CustomerOrder::objects()->count() . PHP_EOL;
        break;
    case 'array':
        testBigSelectArray($limit);
        break;
    case 'object':
        testBigSelectObj($limit);
        break;
    default;
        break;
}

// $sync->delete();
