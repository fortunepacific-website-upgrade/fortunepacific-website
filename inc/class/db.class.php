<?php
/*
Powered by ly200.com		http://www.ly200.com
广州联雅网络科技有限公司		020-83226791
*/

class db{
	private static $link_id=0;
	private static $query_id=0;
	private static $record=array();
	private static $errno=0;
	private static $error='';
	private static $sql='';
	
	public static function connect(){	//连接数据库
		global $c;
		self::$link_id=@mysql_connect($c['db_cfg']['host'].':'.$c['db_cfg']['port'], $c['db_cfg']['username'], $c['db_cfg']['password']);
		self::$link_id || self::halt_msg('无法链接数据库，请检查数据库链接配置文件！');
		@mysql_select_db($c['db_cfg']['database']) || self::halt_msg('无法选择数据库，请检查数据库名称是否正确！');
		$c['db_cfg']['charset'] && @mysql_query("set names '{$c['db_cfg']['charset']}'");
		@mysql_query('set sql_mode=""');
	}
	
	private static function next_record(){	//返回记录集
		self::$record=@mysql_fetch_assoc(self::$query_id);
		$is_array=is_array(self::$record);
		!$is_array && self::$record=array();
		return $is_array;
	}
	
	private static function halt_msg($msg){	//消息提示
		self::$errno=@mysql_errno(self::$link_id);
		self::$error=@mysql_error(self::$link_id);
		exit($msg.'<br>错误代码：<i>#'.self::$errno.'</i> - '.self::$error);
	}
	
	public static function query($sql){	//直接执行SQL语句
		!self::$link_id && self::connect();
		self::$sql=$sql=trim($sql);
		self::$query_id=@mysql_query($sql, self::$link_id);
		!self::$query_id && self::halt_msg('SQL语句出错：'.$sql);
		return self::$query_id;
	}
	
	//------------------------------------------------------------------------以下为查询相关的函数---------------------------------------------------------------
	
	public static function get_all($table, $where=1, $field='*', $order=1){	//返回整个数据表
		self::query("select $field from $table where $where order by $order");
		$result=array();
		while(self::next_record()){
			$result[]=self::$record;
		}
		return $result;
	}
	
	public static function get_limit($table, $where=1, $field='*', $order=1, $start_row=0, $row_count=20){	//分页返回记录
		self::query("select $field from $table where $where order by $order limit $start_row, $row_count");
		$result=array();
		while(self::next_record()){
			$result[]=self::$record;
		}
		return $result;
	}
	
	public static function get_limit_page($table, $where=1, $field='*', $order=1, $page=1, $page_count=20){	//高级形式分页返回记录
		$row_count=self::get_row_count($table, $where);
		$total_pages=ceil($row_count/$page_count);
		($page<1 || $page>$total_pages) && $page=1;
		$start_row=($page-1)*$page_count;
		return array(
			self::get_limit($table, $where, $field, $order, $start_row, $page_count),
			$row_count,
			$page,
			$total_pages,
			$start_row
		);
	}
	
	public static function get_one($table, $where=1, $field='*', $order=1){	//返回一条记录
		self::query("select $field from $table where $where order by $order limit 1");
		self::next_record();
		$result=self::$record;
		return $result;
	}
	
	public static function get_rand($table, $where=1, $field='*', $id_field, $row_count=1){	//返回随机N条记录
		self::query("select $field from $table as t1 join(select round(rand()*((select max($id_field) from $table where $where)-(select min($id_field) from $table where $where))+(select min($id_field) from $table where $where)) as $id_field) as t2 where t1.$id_field>=t2.$id_field and $where order by t1.$id_field asc limit $row_count");
		$result=array();
		while(self::next_record()){
			$result[]=self::$record;
		}
		return $result;
	}
	
	public static function get_value($table, $where=1, $field, $order=1){	//返回一个字段值
		self::query("select $field from $table where $where order by $order limit 1");
		self::next_record();
		$result=self::$record;
		return $result[$field];
	}
	
	public static function get_row_count($table, $where=1){	//返回总记录数
		self::query("select count(*) as row_count from $table where $where");
		if(substr_count(strtolower($where), 'group by')){
			return mysql_num_rows(self::$query_id);
		}else{
			self::next_record();
			$result=self::$record;
			return $result['row_count'];
		}
	}
	
	public static function get_sum($table, $where=1, $field){	//回返合计值
		self::query("select sum($field) as sum_count from $table where $where");
		self::next_record();
		$result=self::$record;
		return $result['sum_count'];
	}
	
	public static function get_max($table, $where=1, $field){	//返回最大的值
		self::query("select max($field) as max_value from $table where $where");
		self::next_record();
		$result=self::$record;
		return $result['max_value'];
	}
	
	public static function get_insert_id(){	//最后一次操作关联ID号
		return mysql_insert_id(self::$link_id);
	}
	
	public static function get_table_fields($table, $only_return_field_name=0){	//返回数据表字段
		self::query("show columns from $table");
		$result=array();
		while(self::next_record()){
			$result[]=$only_return_field_name==0?self::$record:self::$record['Field'];
		}
		return $result;
	}
	
	public static function insert($table, $data){	//插入记录
		while(list($field, $value)=each($data)){
			$fields.="$field,";
			$values.="'$value',";
		}
		$fields=substr($fields, 0, -1);
		$values=substr($values, 0, -1);
		self::query("insert into $table($fields) values($values)");
	}
	
	public static function update($table, $where=0, $data){	//更新数据表
		while(list($field, $value)=each($data)){
			$upd_data.="$field='$value',";
		}
		$upd_data=substr($upd_data, 0, -1);
		self::query("update $table set $upd_data where $where");
	}
	
	public static function insert_update($table, $where, $data){
		self::get_row_count($table, $where)?self::update($table, $where, $data):self::insert($table, $data);
	}
	
	public static function delete($table, $where=0){	//删除数据
		self::query("delete from $table where $where");
	}
	
	public static function lock($table, $method='write'){	//锁定表
		db::query("lock tables $table $method");
	}
	
	public static function unlock(){	//解除锁定表
		db::query('unlock tables');
	}
	
	public static function close(){	//关闭数据库连接
		self::$link_id && mysql_close(self::$link_id);
	}
}
?>