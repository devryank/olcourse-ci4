<?php namespace App\Models;
use CodeIgniter\Model;

class Master_model extends Model 
{
    protected $users = 'users';
    protected $topics = 'topics';
    protected $classes = 'classes';
    protected $packages = 'packages';
    protected $transactions = 'transactions';
    protected $class_packages = 'class_packages';

    public function get_all($table)
    {
        $query = $this->db->table($table)
                          ->get();
        return $query;
    }

    public function get_select($table, $select, $where)
    {
        $query = $this->db->table($table)
                          ->select($select)
                          ->where($where)
                          ->get();
        return $query;
    }

    public function get_field($table, $where)
    {
        $query = $this->db->table($table)
                          ->where($where)
                          ->get();
        return $query;
    }

    public function get_order($table, $where, $order)
    {
        $query = $this->db->table($table)
                          ->where($where)
                          ->orderBy($order)
                          ->get();
        return $query;
    }

    public function get_join($table, $select, $table2, $join, $where)
    {
        $query = $this->db->table($table)
                          ->select($select)
                          ->join($table2, $join)
                          ->where($where)
                          ->get();
        return $query;
    }

    public function insert_data($table, $data)
    {
        $query = $this->db->table($table)
                          ->insert($data);
        return $query;
    }

    public function insert_data_get_last_id($table, $data)
    {
        $query = $this->db->table($table)
                          ->insert($data);
        if($query)
        {
            $id = $this->db->insertID();
            return $id;
        } else {
            return $query;
        }
    }

    public function insert_data_batch($table, $data)
    {
        $query = $this->db->table($table)
                          ->insertBatch($data);
        return $query;
    }

    public function update_data($table, $where, $data)
    {
        $query = $this->db->table($table)
                          ->where($where)
                          ->update($data);
        return $query;
    }

    public function update_data_batch($table, $data, $title)
    {
        $query = $this->db->table($table)
                          ->updateBatch($data, $title);
        return $query;
    }

    public function delete_data($table, $where)
    {
        $query = $this->db->table($table)
                          ->where($where)
                          ->delete();
        return $query;
    }

    public function delete_array($table, $where, $array)
    {
        $query = $this->db->table($table)
                          ->whereIn($where, $array)
                          ->delete();
        return $query;
    }

    public function count_data($table, $where)
    {
        $query = $this->db->table($table)
                          ->where($where)
                          ->countAllResults();
        return $query;
    }

    public function count_data_group($table, $where, $group)
    {
        $query = $this->db->table($table)
                          ->where($where)
                          ->groupBy($group)
                          ->countAllResults();
        return $query;
    }

    public function get_last_insert_id($table, $column)
    {
        $query = $this->db->table($table)
                          ->select($column)
                          ->limit('1')
                          ->orderBy($column, 'desc')
                          ->get();
        return $query;
    }

    // START GRAFIK

    public function getMonth()
    {
        $query = $this->db->table($this->transactions)
                          ->select("MONTHNAME(STR_TO_DATE(MONTH(order_date), '%m')) as bulan")
                          ->where('is_paid', '1')
                          ->where('YEAR(order_date) = YEAR(CURRENT_DATE())')
                          ->orderBy("STR_TO_DATE(MONTH(order_date), '%m')")
                          ->groupBy("MONTH(order_date)")
                          ->get();
        return $query;
    }
    
    public function totalTransactionsPerMonth()
    {
        $query = $this->db->table($this->transactions)
                          ->select("COUNT(transaction_id) as jml")
                          ->where('is_paid', '1')
                          ->where('YEAR(order_date) = YEAR(CURRENT_DATE())')
                          ->orderBy("STR_TO_DATE(MONTH(order_date), '%m')")
                          ->groupBy("MONTH(order_date)")
                          ->get();
        return $query;
    }
    // END GRAFIK
    
    public function verification($username)
    {
        $query = $this->db->table($this->users)
                          ->where('username', $username)
                          ->update(['is_active' => '1']);
        return $query;
    }

    public function get_topik()
    {
        $query = $this->db->table($this->topics)
                          ->select('topics.topic_name, topics.number, topics.slug as slug_topic, classes.class_name, classes.slug as slug_class')
                          ->join('classes', 'classes.class_id=topics.class_id')
                          ->orderBy('topics.number')
                          ->get();
        return $query;
    }

    public function get_topik_by_slug($slug_class, $slug_topic)
    {
        $query = $this->db->table($this->topics)
                          ->select('topics.topic_name, topics.class_id, topics.number, classes.class_id, classes.class_name, topics.content')
                          ->join('classes', 'classes.class_id=topics.class_id')
                          ->where(['classes.slug' => $slug_class, 'topics.slug' => $slug_topic])
                          ->get();
        return $query;
    }

    public function update_topik($where, $data)
    {
        $query = $this->db->table($this->topics)
                          ->where($where)
                          ->update($data);
        return $query;
    }

    public function get_package()
    {
        $query = $this->db->table($this->packages)
                          ->select('packages.package_id,packages.package_name, packages.slug, packages.price, packages.duration, packages.created_at, GROUP_CONCAT(classes.class_name) as class_name')
                          ->join('class_packages', 'class_packages.package_id=packages.package_id')
                          ->join('classes', 'classes.class_id=class_packages.class_id')
                          ->groupBy('packages.package_id')
                          ->get();
        return $query;
    }

    public function get_to_edit_package($where)
    {
        $query = $this->db->table($this->packages)
                          ->select('packages.package_id,packages.package_name, packages.slug, packages.price, packages.detail, packages.duration, packages.img, packages.created_at, GROUP_CONCAT(classes.class_id) as class_id')
                          ->join('class_packages', 'class_packages.package_id=packages.package_id')
                          ->join('classes', 'classes.class_id=class_packages.class_id')
                          ->where($where)
                          ->get();
        return $query;
    }

    public function transactions_package_admin()
    {
        $query = $this->db->table($this->transactions)
                          ->select('transactions.transaction_id, transactions.user_id, transactions.id, transactions.option, transactions.discount_id, transactions.amount, transactions.order_date,
                                    packages.package_name, discounts.discount, users.full_name')
                          ->join('packages', 'packages.package_id=transactions.id')
                          ->join('discounts', 'discounts.discount_id=transactions.discount_id')
                          ->join('users', 'users.user_id=transactions.user_id')
                          ->where('transactions.option', 'package')
                          ->get();
        return $query;
    }

    public function transactions_class_admin()
    {
        $query = $this->db->table($this->transactions)
                          ->select('transactions.transaction_id, transactions.user_id, transactions.id, transactions.option, transactions.discount_id, transactions.amount, transactions.order_date,
                                    classes.class_name, discounts.discount, users.full_name')
                          ->join('classes', 'classes.class_id=transactions.id')
                          ->join('discounts', 'discounts.discount_id=transactions.discount_id')
                          ->join('users', 'users.user_id=transactions.user_id')
                          ->where('transactions.option', 'class')
                          ->get();
        return $query;
    }

    // -------------- HOME ---------------//
    
    public function search($match)
    {
        $package_search = $this->db->table($this->packages)
                                   ->select('packages.package_name, packages.slug, packages.img, packages.price, packages.detail')
                                   ->like('package_name', $match)
                                   ->get()->getResult();
        
        $class_search = $this->db->table($this->classes)
                                 ->select('classes.class_name, classes.slug, classes.img, classes.price, classes.detail')
                                 ->like('class_name', $match)
                                 ->get()->getResult();
        $query = [
            'package_search' => $package_search,
            'class_search' => $class_search,
        ];
        return $query;
    }

    public function show_package()
    {
        $query = $this->db->table($this->packages)
                          ->select('packages.package_name, packages.slug, packages.img, packages.price, packages.detail, COUNT(packages.package_name) as TotalClass')
                          ->groupBy('package_name')
                          ->get();
        return $query;
    }

    public function show_popular_package()
    {
        $query = $this->db->table($this->transactions)
                          ->select('packages.package_name, packages.slug, packages.img, packages.price, packages.detail')
                          ->join('packages', 'packages.package_id=transactions.id')
                          ->where('transactions.option', 'package')
                          ->limit('3')
                          ->groupBy('transactions.id')
                          ->orderBy('count(transactions.id)', 'desc')
                          ->get();
        return $query;
    }

    public function show_package_with_limit()
    {
        $query = $this->db->table($this->packages)
                          ->select('packages.package_name, packages.slug, packages.img, packages.price, packages.detail')
                          ->limit('3')
                          ->get();
        return $query;
    }

    public function show_class_with_limit()
    {
        $query = $this->db->table($this->classes)
                          ->select('classes.class_name, classes.slug, classes.img, classes.price, classes.detail')
                          ->limit('3')
                          ->get();
        return $query;
    }

    public function show_package_or_class_user($join, $where)
    {
        $query = $this->db->table($this->transactions)
                          ->join($join, $where)
                          ->where([
                              'transactions.user_id' => session()->get('user_id'),
                              'transactions.is_paid' => '1',
                              'transactions.is_token_activated' => '1'
                              ]);
        return $query;
    }

    public function show_list_class($package_id)
    {
        $query = $this->db->table($this->class_packages)
                          ->select('classes.class_name, classes.slug, classes.img')
                          ->join('classes', 'classes.class_id=class_packages.class_id')
                          ->where('class_packages.package_id', $package_id)
                          ->get();
        return $query;
    }

    public function show_list_topics_left_passes($where)
    {
        $query = $this->db->table($this->topics)
                          ->select('topics.topic_name, topics.slug, passes.topic_id')
                          ->join('passes', 'passes.topic_id=topics.topic_id', 'left')
                          ->where($where)
                          ->orderBy('topics.number')
                          ->get();
        return $query;
    }

    public function get_invoice($user_id)
    {
        $query = $this->db->query("SELECT DISTINCT transactions.option, transactions.transaction_id, transactions.id, course_id, course_name, transactions.amount, transactions.waiting_confirmation, transactions.is_paid, transactions.order_date, transactions.token FROM `transactions` JOIN ((SELECT packages.package_id as course_id, packages.package_name as course_name from packages JOIN transactions ON transactions.id = packages.package_id where transactions.option = 'package') UNION (SELECT classes.class_id as course_id, classes.class_name as course_name from classes JOIN transactions ON transactions.id = classes.class_id where transactions.option = 'class')) ids ON transactions.id = course_id where transactions.user_id = $user_id GROUP by transactions.transaction_id");
        return $query;
    }

    public function get_transaksi()
    {
        $query = $this->db->query("SELECT DISTINCT transactions.option, transactions.transaction_id, transactions.id, course_id, course_name, transactions.amount, transactions.waiting_confirmation,transactions.is_paid, transactions.order_date, transactions.token FROM `transactions` JOIN ((SELECT packages.package_id as course_id, packages.package_name as course_name from packages JOIN transactions ON transactions.id = packages.package_id where transactions.option = 'package') UNION (SELECT classes.class_id as course_id, classes.class_name as course_name from classes JOIN transactions ON transactions.id = classes.class_id where transactions.option = 'class')) ids ON transactions.id = course_id where is_paid = '0' GROUP by transactions.transaction_id");
        return $query;
    }

    public function check_course_end_date($user_id, $package_id)
    {
        $query = $this->db->table($this->transactions)
                          ->select('course_end_date')
                          ->where(['user_id' => $user_id,
                                   'option' => 'package',
                                   'id' => $package_id])
                          ->orderBy('course_end_date', 'desc')
                          ->get();
        return $query;
    }

}