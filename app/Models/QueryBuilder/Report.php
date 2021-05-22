<?php

namespace App\Models\QueryBuilder;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Report extends Model
{
    public function getReportTransactions($users_id)
    {
        $sql = "SELECT a.products_id , b.name as product,
                SUM(a.price * a.qty) as subtotal,
                SUM(b.profit_sharing * a.qty) as total_profit_sharing
                from transaction_details as a
                join products as b on a.products_id = b.id
                join users as c on b.users_id = c.id
                where c.id = $users_id
                GROUP by a.products_id, b.name , a.price ";
        $result = DB::select($sql);
        return $result;
    }
}
