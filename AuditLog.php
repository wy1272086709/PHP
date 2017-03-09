<?php
namespace app\models;

set_time_limit(2400);
ini_set('memory_limit', '2048M');
use app\modules\wz\models\Place;
use Yii;
use app\models\Factory;
use app\models\ServiceInfo;
use app\models\EquipmentInfo;
use app\models\TerminalCompany;
use app\models\SystemLog;
use app\models\AuthType;
use app\models\Protocol;
use app\models\Areacode;
use app\components\common\File;
use app\components\helpers\CommonHelper;
use app\components\estaticsearch\EsCommand;
use app\components\estaticsearch\CommonActiveQuery;
use app\components\estaticsearch\CommonQuery;
use app\components\estaticsearch\BaseModel;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{mac/ap_%}}".
 */
class AuditLog extends BaseModel{

	public  function attributes($attr = '')
    {	
			 return [ 	
			 		'id','area_code','ssid', 'access_ap_mac','identitication_type', 'identitication_account','end_time','connect_num','index','total', 
			     	'session_id','service_code','equipment_code','service_name','equipment_name','signal','access_ap_mac','equipment_longitude','equipment_latitude','access_ap_ssid','access_ap_channel','access_ap_encryption_type',
     			    'factory_code', 'protocol_code','factory_name'	,'ip','port','src_ipv4',
     			 	'src_ipv6','src_port_start','src_port_end','src_port_start_ipv6','src_port_end_ipv6',
     				'dest_ip','dest_ipv6','dest_port','dest_port_ipv6','longitude',
     				'mac','latitude','auth_type','app_type','auth_account','app_code',
     				'app_account_id','create_time','short_content','url'	,
     				'host','title','content_type','username','password', 'password_hash','referer',
     				 'sender','reciver','subject', 'mail_frompart', 'mail_topart', 'cc'	,
     				'bcc','domain'	,'content_type'	,'mail_software','mail_length','main_text'	,'send_time'	, 'view_status'	,'folder','delete_status','delete_time', 'fom_id'	,'from_nickname'	,'to_id'	,'to_nickname'	,'action','content'	,'send_time'	, 'identification_type','keyword','bbs_name','nickname','bbs_board_id','bsb_board_name','copy_from','link_url','author','author_mail','issue_status','topic_id','title','topic_id','subject','topic_author'	,'mblog_id', 'message','info_type',  	 'sendtype','time','buyaccount','buynickname','sellaccount','sellnickname','order_num', 'goods_id'	,'goodsname'	, 'buyphone', 'buytel','buycount','money','buytime','addresstime', 'address','contact_account_type', 'contact_account', 'leaveword','mobile','pickup_certificate_type','pickup_certificatecode','reg_account_type','reg_account', 'pay_account_type', 'pay_account','recivername'	 
     			];
		
    }
     public function getFileds($data_type){
     	
     		if($data_type == 'mac_ap'){
     			return [
     			 'id'                                  	 	=> '序号', 
     			 'mac'							    	=> 'mac',
     			 'service_name'					   => '场所名称',
     			 'equipment_code'         	 	=> '设备编码',
     			 'equipment_name'          		=> '设备名称',
     			 'factory_code'				 	 	=> '厂商组织机构代码',
     			 'factory_name'				   		=> '厂商名称',
     			 'access_ap_mac'					=> '接入热点mac',
     			 'log_type'					 			=> '日志类型',
     			 'create_time'	   					=> '开始时间',
     			 'end_time'							=> '结束时间', 
     			 'connect_num'						=> '采集次数',
     			 'x_coordinate'						=>'设备x轴', 
     			 'y_coordinate'						=> '设备y轴', 
     			 'equipment_longitude'       	=> '设备经度', 
     			 'equipment_latitude'			=> '设备纬度', 
     			 'identitication_type'			 	=> '身份类型', 
     			 'identitication_account'		=> '身份内容', 
     			 'imsi'									=> 'IMSI',
     			 'imei'									=> 'IMEI',
     			 'data_type'							=> '数据类型',
     			  'index'									=> '表（索引）名称'
     			 ];
     			
     		}else if($data_type == 'internet_log'){
     			return [
     			 'id'                                  	 	=> '序号', 
     			 'service_name'					   => '场所名称',
     			 'factory_name'				   		=> '厂商名称',
     			 'auth_type'								=> '认证类型',
     			 'auth_account'						=> '认证账号',
     			 'app_account_id'					=> '虚拟账号',
     			 'app_type'			 				=> '协议类型', 
     			 'ip'										=> 'ip地址',
     			 'src_ipv4'								=> '源外网ip地址', 
     			 'mac'									=> 'mac地址', 
     			 'create_time'	   					=> '行为产生时间',
     			 'short_content'						=>'信息摘要', 
     			  'index'									=> '表（索引）名称',
     			  'app_code'			 				=> '协议类型（大类）', 
     			 ];
     			
     		}
     	
     }
  
       public function getFiledsByDetail($data_type,$flag){
     	
     		if($data_type == 'mac_ap'){
     			return [
     			 'service_code'					  	 => '场所编码',
     			 'equipment_code'         	 	=> '设备编码',
     			 'service_name'					=> '场所名称',
     			 'equipment_name'          		=> '设备名称',
     			 'factory_code'				 	 	=> '厂商组织机构代码',
     			 'mac'							    		=> 'mac',
     			 'factory_name'				   	=> '厂商名称',
     			 'phone'								=> '手机号码',
     			  'terminal_company'			=> '终端厂商',
     			  'imsi'									=> 'IMSI',
     			 'ssid'									=> '历史SSID',
     			 'imei'									=> 'IMEI',	 
     			 'x_coordinate'						=>'设备x轴', 
     			 'equipment_longitude'       => '设备经度', 
     			 'y_coordinate'						=> '设备y轴', 
     			 'equipment_latitude'			=> '设备纬度', 
     			 'identitication_type'			 => '身份类型', 
     			  'signal'								=> '信号强度',
     			 'identitication_account'		=> '身份内容', 
     			 'access_ap_mac'					=> '接入热点mac',
     			 'access_ap_ssid'					=> '接入热点SSID',
     			 'access_ap_channel'			 => '接入热点频道/IP',
     			 'access_ap_encryption_type'=> '接入热点加密类型',
     			 'data_type'					 		=> '日志类型',
     			 'create_time'	   					=> '开始时间',
     			  'connect_num'					=> '采集次数',
     			 'end_time'							=> '结束时间', 
     			   'index'								=> '表（索引）名称'
     			 ];
     		}else if($data_type == 'internet_log'){
     			$re_flag = [];
     			$re = [
     				//'session_id'					=> '会话ID',
     				'service_code'				=> '场所编码',
     			    'equipment_code'        => '设备编码',
     			    'service_name'				=> '场所名称',
     			   'equipment_name'        => '设备名称',
     			   'factory_code'				=> '厂商组织机构代码',
     			   'protocol_code'			=> '网络应用服务类型',
     			 	'factory_name'			=> '厂商名称',
     				'ip'								=> '场所内网IP地址',
     				'port'							=> '场所内网端口号',
     				'src_ipv4'				 	 	=> '源外网IPv4地址',
     			 	'src_ipv6'				   		=> '源外网IPv6地址',
     				'src_port_start'			=> '源外网IPv4起始端口号',
     				'src_port_end'				=> '源外网IPv4结束端口号',
     				'src_port_start_ipv6'	=> '源外网IPv6起始端口号',
     				'src_port_end_ipv6'		=> '源外网IPv6结束端口号',
     				'dest_ip'						=> '目的公网IPv4地址',
     				'dest_ipv6'					=> '目的公网IPv6地址',
     				'dest_port'				 	=> '目的公网IPv4端口号',
     			 	'dest_port_ipv6'			=> '目的公网IPv6端口号',
     				'longitude'					=> '移动AP纬度',
     				'mac'							=> '终端MAC地址',	
     				'latitude'						=> '移动AP经度',
     				'auth_type'				 	=> '认证类型',
     				'app_type'					=> '协议类型',
     			 	'auth_account'				=> '认证账号',
     				//'app_code'				=> '应用分类',
     				'app_account_id'			=> '虚拟账号',
     				'create_time'				=> '日志记录时间',
     				'short_content'				=> '信息摘要',
     				
     				
     			];
     			if($flag == 'http'){
     				$re_flag =[
     					 'url'							=> '网址',
     					 'host'						=> '网页域名',
     					 'title'						=> '网页标题',
     					 'content_type'			=> 'HTTP头部ContentType内容',
     					 'username'				=> '用户名',
     					 'password'				=> '密码',
     					 'password_hash'		=> '密码串hash值',
     					 'referer'					=> '上层页面url',
     				];
     			}else if($flag == 'email'){
     				$re_flag =[
     					 'sender'					=> '发件人',
     					 'reciver'					=> '收件人',
     					 'username'				=> '用户名',
     					 'password'				=> '密码',
     					 'password_hash'		=> '密码串hash值',
     					 'subject'					=> '主题',
     					 'mail_frompart'		=> '信息体from段收件人',
     					 'mail_topart'			=> 'to段收件人',
     					 'cc'							=> 'cc段收件人',
     					 'bcc'						=> 'bcc段收件人',
     					 'domain'					=> '域名',
     					 'content_type'			=> 'http头content_type内容',
     					 'mail_software'		=> '已装软件信息',
     					 'mail_length'			=> '正文长度',
     					 'main_text'				=> '正文',
     					 'send_time'				=> '发送时间',
     					  'view_status'			=> '阅读状态',
     					 'folder'					=> '存储位置',
     					 'delete_status'		=> '删除状态',
     					 'delete_time'			=> '删除时间',
     				];
     			}else if($flag == 'chat'){
     				$re_flag =[
     					 'fom_id'					=> '信息发送者id',
     					 'from_nickname'		=> '发送者昵称',
     					 'to_id'						=> '接收者id',
     					 'to_nickname'			=> '接收者昵称',
     					 'username'				=> '用户名',
     					 'password'				=> '密码',
     					 'password_hash'		=> '密码串hash值',
     					 'action'					=> '状态',
     					 'content'					=> '内容',
     					 'send_time'				=> '发送时间',
     				];							
				}else if($flag == 'search'){
     				$re_flag =[
     					 'identification_type'				 => '合作账号类型',
     					 'url'											=> '网址',
     					 'username'								=> '用户名',
     					 'password'								=> '密码',
     					 'password_hash'						=> '密码串hash值',
     					 'keyword'								=> '关键字',
     				];			
				}else if($flag == 'bbs'){
     				$re_flag =[
     					 'url'											=> '网址',
     					 'bbs_name'								=> '论坛名称',
     					 'identification_type'				=> '合作账号类型',
     					  'username'								=> '论坛账号',
     					 'password'								=> '密码',
     					 'password_hash'						=> '密码串hash值',
     					 'nickname'								=> '昵称',
     					 'bbs_board_id'						=> '板块id',
     					 'bsb_board_name'					=> '板块名称',
     					 'copy_from'							=> '帖子来源',
     					 'link_url'									=> '链接信息',
     					 'author'									=> '帖子作者',
     					 'author_mail'							=> '作者邮箱地址',
     					 'content'									=> '内容',
     					 'action'									=> '动作类型',
     					 'issue_status'							=> '帖子状态',
     					 'topic_id'									=> '帖子id',
     				];
				}else if($flag == 'blog'){
     				$re_flag =[
     					 'identification_type'				=> '合作账号类型',
     					 'url'										   => '网址',
     					 'domain'									=> '域名',
     					  'referrer'									=> 'referrer',
     					  'username'								=> '论坛账号',
     					 'password'								=> '密码',
     					 'password_hash'						=> '密码串hash值',
     					 'nickname'								=> '昵称',
     					 'title'										=> '帖子标题',
     					  'topic_id'								=> '帖子id',
     					 'subject'									=> '主题',   					 
     					 'topic_author'							=> '作者',
     					 'copy_from'							=> '转载自',
     					 'content'									=> '内容',
     					 'action'									=> '动作类型',
     					 'issue_status'							=> '帖子状态',
     				];     			

				}else if($flag == 'weibo'){
     				$re_flag =[
     					 'identification_type'			=> '合作账号类型',
     					  'mblog_id'							=> '微博id',
     					 'url'										=> '网址',
     					 'domain'								=> '域名',
     					  'referrer'								=> 'referrer',
     					  'username'							=> '论坛账号',
     					 'password'							=> '密码',
     					 'password_hash'					=> '密码串hash值',
     					 'nickname'							=> '昵称',
     					 'title'									=> '页面标题',
     					  'message'							=> '消息内容',
     					 'info_type'							=> '信息类型',   	
     					  'action'								=> '动作类型',			
      					 'issue_status'						=> '信息状态',    					  	 
     					 'sendtype'							=> '发送方式',
     					 'time'								  	 => '发送时间',
     				];  					

				}else if($flag == 'buy'){
     				$re_flag =[
     					 'identification_type'			=> '合作账号类型',
     					  'url'										=> '网址',
     					 'buyaccount'						=> '用户账号',
     					 'password'							=> '密码',
     					 'password_hash'					=> '密码串hash值',
     					 'buynickname'					=> '用户昵称',
     					  'sellaccount'						=> '卖家id',
     					 'sellnickname'						=> '卖家昵称',
     					 'order_num'						=> '订单号',
     					  'goods_id'							=> '商品id',
     					 'goodsname'						=> '商品名称',   	
     					  'buyphone'						=> '买家手机号',			
      					 'buytel'								=> '买家固话号码',    					  	 
     					 'buycount'							=> '购买数量',
     					 'money'								=> '总金额',
     					 'buytime'							=> '购买时间',
     					 'addresstime'						=> '预约收货时间',
     					  'address'							=> '收货地址',
     					 'contact_account_type'		=> '购买者联系人账号类型',   	
     					  'contact_account'				=> '购买者联系人账号',			
      					 'leaveword'							=> '购买者留言',    					  	 
     					 'username'							=> '购买者个人资料用户名',
     					 'mobile'								=> '电话',
     					  'pickup_certificate_type'	=> '证件类型',
     					 'pickup_certificatecode'		=> '证件号码',
     					  'reg_account_type'			=> '注册账号类型',
     					 'reg_account'						=> '注册账号',   	
     					  'pay_account_type'			=> '付款账号类型',			
      					 'pay_account'						=> '付款账号',    					  	 
     					 'recivername'						=> '收货人',
     					 'keyword'							=> '关键字',
     				];       			
				}
     			return array_merge($re,$re_flag);
     		}
     	
     }
     
      public function getExportFileInfo($data_type){
      		$path = "/data/www/wcenter/tmp/";     
      		if($data_type == 'mac_ap'){
      			$file_name = "终端特征日志列表_".time().".csv";
      		}else if($data_type == 'internet_log'){
      			$file_name = "上网日志列表_".time().".csv";
      	    }else if($data_type == 'mac_log'){
      	    	$file_name = "MAC日志列表_".time().".csv";
      	    }else if($data_type == 'ap_log'){
      	    	$file_name = "AP日志列表_".time().".csv";
      	    }else if($data_type == 'account_log'){
      	    	$file_name = "虚拟账号日志列表_".time().".csv";
      	    }
      	    return array($path,$file_name);
      }
	
	//入口
	  public  function query($post){
			if($post['data_type'] == "mac_ap"){ //目前版本mac日志和ap日志合并在一起
					if(isset($post['log_type']) && $post['log_type'] !=0){
							if($post['log_type'] == 1){
								$t = AuditLog::getTables('mac',$post['begin_time'],$post['end_time']);
							}else{
								$t = AuditLog::getTables('ap',$post['begin_time'],$post['end_time']);
							}
					}else{
						$tables_mac = AuditLog::getTables('mac',$post['begin_time'],$post['end_time']);
						$tables_ap = AuditLog::getTables('ap',$post['begin_time'],$post['end_time']);
						$t = array_merge($tables_mac,$tables_ap);
					}
					
					$tables = [];
					foreach($t as $k => $v){
						$tables[substr($k,-10,10)][] = $v;
					}
					
			}else{
					$tables_tmp = AuditLog::getTables($post['data_type'],$post['begin_time'],$post['end_time']);
					$tables = [];
					foreach($tables_tmp as $k => $v){
						$tables[substr($k,-10,10)][] = $v;
					}
			}
			$act = $post['act'];
			if($act == 'getdata'){ //查询数据
				$re = [];
				$data = AuditLog::getData($tables,$post);
				$fields = AuditLog::getFileds($post['data_type']);
				if(isset($data['data']))
				{
					$re = AuditLog::setData($data, $fields,$post['data_type'],$post['act']);
				}
				return $re;
				
			}else if($act == 'total'){ //查询总数
				return 	AuditLog::getTotal($tables,$post);	
				
			}else if($act == 'collection_total'){ //查询采集总数		
				return 	AuditLog::getCollectionTotal($tables,$post);	
				
			}else if($act == 'distinct_total'){ //查询去重总数
				return 	AuditLog::getDistinctTotal($tables,$post);	
				
			}else if($act == 'export'){ //导出
				$data = AuditLog::getExplode($tables,$post);	

				return $data;
			}else{
				return false;
			}
	}
	
	//查询数据
	public  function getData($tables,$post){
			$condition = AuditLog::setWhere($post);
			$where = $condition[0];
			$query = $condition[1];
			$flag = $condition[2];
			$where_str = $condition[3];
			$query_keyword = $condition[4];
			$desc = $condition[5];
			if($flag == 0){
				// return array();	
				return array('desc'=>$desc);
			}		
			$file = \Yii::$app->getRuntimePath().'/AUDITLOG.txt';
			$page = $post['page']; //第几页
			$page_size = $post['page_size']; //每页数量
			$page_last	= $post['page_last'];	//标注是否点击了末页
			$total	= $post['total']; //数量总数			
			 CommonHelper::writeLog("POST页码：:".$page, 'DEGUG',$file);	
			 CommonHelper::writeLog("page_last：:".$page_last, 'DEGUG',$file);	
			if( (isset($page_last) && $page_last == "Y") || ($page >ceil($total/$page_size)/2 && $page > 100)){ 
				//点击末页，时间顺序查询
				$page_last = "Y";
				$page = intval((ceil($total/$page_size)-$page)+1);
				 CommonHelper::writeLog("计算页码:".$page, 'DEGUG',$file);	
				
				$last_num = bcmod($total, $page_size);
				if($page == 1){ //末页需要取的数据
					if($last_num == 0){
						//$limit =  $page_size;
						$limit =  $page_size*10;
					}else{
						//$limit =  $last_num;
						$limit =  $page_size*9+$last_num;
					}
					
					$offset = 0;
				}else{ 
					//$limit = $page_size;
					$limit =  $page_size*10;
					$offset = ($page - 1) * $page_size-$page_size+$last_num;
				}
				$order_by = SORT_ASC;
				ksort($tables);
			}else{ //从首页，倒序查询
				//$offset = ($page - 1) * $page_size;
				$offset = floor(($page-1)/10)*10*$page_size;
				//$limit =  $page_size;
				$limit =  $page_size*10;
				$order_by = SORT_DESC;
				$last_num = 0;
			}
			$key_flag = ceil($page/10).$order_by;
			$table_key_str = '';
			foreach ($tables as $table_tmp) {
				 	 
				 if(is_array($table_tmp)){
				 		$table_key_str .= join(",",$table_tmp);
				 }else{
				 		$table_key_str .= $table_tmp.',';
				 }
			}
		 	//$cache_key = md5($table_key_str.'_'.$where_str."_".$page_size."_".$key_flag);
		 	$cache_key = md5($table_key_str.'_'.$where_str."_".$page_size."_".$key_flag);		 
			$cache_data = Yii::$app->cache->get($cache_key);
			
		   $is_cache = "N";
		   CommonHelper::writeLog("最初offset:".$offset, 'DEGUG',$file);	
			if($cache_data == false || $page == 1){
				 CommonHelper::writeLog("缓存的值为：空", 'DEGUG',$file);
					$re = array();
					$re['total'] = 0;
					$re['data'] = array();
					$re['desc'] = $desc;
					$have_total = 0;
					$total_offset = $offset;
					$limit_new = $limit;
					foreach($tables as $table){
							$where_tmp = AuditLog::setTimeWhere($table,$post);
							$where_new = $where;
							if(!empty($where_tmp)){
								if(count($where) > 0){
									$where_new[] = $where_tmp;
								}else{
									$where_new = $where_tmp;
								}
								
						   }
						   $condition = [];
						   $condition['where'] = $where_new;
						   $condition['where_str'] = $where_str;
						   $condition['order_by'] = $order_by;
						   $condition['limit'] = $limit_new;
						   $condition['page_size'] = $page_size;
						   $condition['offset'] = $offset;
						   $condition['last_num'] = $last_num;
						   $condition['data_type'] = $post['data_type'];
						   $condition['act'] = $post['act'];
						   $condition['query_keyword'] = $query_keyword;
						   $condition['page'] = $post['page'];
						   $re_tmp = AuditLog::getOneDayData($table,$condition);
						   $re_total = count($re_tmp['data']);
						    CommonHelper::writeLog("查询到数据条数:".$re_total, 'DEGUG',$file);	
							if($re_tmp['total'] == 0)
							{
								continue;
							}
							if($re_total > 0){
											$re['total'] += $re_tmp['total'] ;
											if(count($re['data']) > 0)
											{
												$re['data'] = array_merge($re['data'],$re_tmp['data']) ;
											}
											else
											{
												$re['data'] = $re_tmp['data'];
											}
											
							}
							if($re_total >= $limit_new){
										break;
							}else{
										$have_total  += $re_tmp['total'];
										if($have_total >= $total_offset){
											$offset =0 ;
										}else{
											$offset = $total_offset-$have_total ;
										}
										$limit_new = $limit_new-$re_total;
										  CommonHelper::writeLog("查询过程：have_total:".$have_total, 'DEGUG',$file);	
										  CommonHelper::writeLog("查询过程：limit_new:".$limit_new, 'DEGUG',$file);	
										  CommonHelper::writeLog("查询过程：offset:".$offset, 'DEGUG',$file);	

							}
					}
					if($order_by == SORT_ASC){ //如果是顺序查询（点击末页），还需要将查询出来的数据排序（倒序显示）
						if(count($re['data']) > 0){
							foreach($re['data'] as $key => $val){
								$ids[$key] = $val['id'];
								$time_arr[$key] = strtotime($val['create_time']);
							}
							array_multisort($time_arr,SORT_NUMERIC,SORT_DESC,$ids,SORT_STRING,SORT_ASC,$re['data']);
						}	
				  }
				  if(count($re['data']) >= $limit){
				  		Yii::$app->cache->set($cache_key,$re,120);
				  }		
				  CommonHelper::writeLog("查询到条数：".count($re['data']), 'DEGUG',$file);	
			}else{
				$re = $cache_data;
				$is_cache = "Y"; 
			}
			//print_r($re);
			
			$re_new['total'] = $re['total'];
			$re_new['desc'] = $re['desc'];
			$re_new['data'] = array();

			$a = $page%10 == 0 ? 10 : $page%10;
			$i = ($a-1)*$page_size;
			if($page_last == "Y" &&  $page != 1 && ceil($page/10) == 1){
				 $i = $i-$page_size+$last_num;
			}
			if($page_last == "Y" && $page == 1){
				 $t = $last_num;	
			}else{
				$t = $i+$page_size;
			}
			 CommonHelper::writeLog("KEY：".$cache_key, 'DEGUG',$file);
			 CommonHelper::writeLog("查询: 是否缓存：".$is_cache." 页码：".$page."--偏移量：".$i."--最后偏移量：".$t, 'DEGUG',$file);
			for($i=$i;$i< $t;$i++){
					 		if(isset($re['data'][$i])){
					 			$re_new['data'][$i] = $re['data'][$i];
					 		}else{
					 			break;	
					 		}
			}
			return $re_new;  	
	}
/*
	//获取一天里面的数据
	public  function getOneDayData($table,$condition){
		 $where = $condition['where'];
		 $where_str	= $condition['where_str'];
		 $order_by =  $condition['order_by'];
		 $limit = $condition['limit'];
		 $offset = $condition['offset'];
		 $last_num = $condition['last_num'];
		 $data_type = $condition['data_type'];
		 $act  = $condition['act'] ;
		 $page = $condition['page'];
		 $query_keyword  = $condition['query_keyword'];		
	
		 $key_flag = ceil(($offset+$condition['page_size']-$last_num+1)/(10*$limit)).$order_by;
		 $key_where = md5($where_str);
		 $key = md5(rtrim(join(",",$table),'*').'_'.$key_where."_".$key_flag);		 
		 $file = \Yii::$app->getRuntimePath().'/AUDITLOG.txt';
		if($act == "getdata"){
			if($offset == 0){
				 $limit_new = $limit+$condition['page_size']*9; //取10页数据缓存,如果是从末页查起，末页不一定有一页的数量
				 $data = AuditLog::find()->from($table, "type")->where($where)->query($query_keyword)->orderBy(['create_time' => $order_by])->limit($limit_new)->offset($offset)->all();
				 CommonHelper::writeLog("查询出来的数据1:".json_encode($data), 'DEGUG',$file);
				 Yii::$app->cache->set($key,$data,300);
				 $re['total'] = $data['total'];
				 $re['data'] = array();
				 $i = 0;
				 foreach($data['data'] as $v){
				 		if($i == $limit) break;
				 		$re['data'][$i] = $v;
				 		$i++;
				 }
				 return $re; 
			}else{

				$data = Yii::$app->cache->get($key);
				CommonHelper::writeLog("从KEY:".$key, 'DEGUG',$file);
				CommonHelper::writeLog("从memcache取出来的数据:".json_encode($data), 'DEGUG',$file);
				if($data == false){
					    $limit_new = $limit*10; //取10页数据缓存
						$offsert_new = (ceil(($offset+$condition['page_size']-$last_num+1)/(10*$limit))-1)*$condition['page_size']*10;
						CommonHelper::writeLog("查询偏移量:".$offset."------".$offsert_new.'-------'.$limit_new, 'DEGUG',$file);
						 $data = AuditLog::find()->from($table, "type")->where($where)->query($query_keyword)->orderBy(['create_time' =>  $order_by])->limit($limit_new)->offset($offsert_new)->all();
						 CommonHelper::writeLog("查询出来的数据2:".json_encode($data), 'DEGUG',$file);
						 Yii::$app->cache->set($key,$data,300);
						 $re['total'] = $data['total'];
						 $re['data'] = array();
						 $i = $offset%($limit*10);
						 $t = $i+$limit;
						 foreach($data['data'] as $v){
						 		if($i == $t) break;
						 		$re['data'][$i] = $v;
						 		$i++;
						 }
						 return $re; 
				}else{
					 $re['total'] = $data['total'];
					 $re['data'] = array();
					 $i = $offset%($limit*10);
					 $t = $i+$limit;
					 for($i=$i;$i< $t;$i++){
					 		if(isset($data['data'][$i])){
					 			$re['data'][$i] = $data['data'][$i];
					 		}else{
					 			break;	
					 		}
					 }
					 return $re;  	
				}
			}
		}else{
			$re = AuditLog::find()->from($table, "type")->where($where)->orderBy(['create_time' => $order_by])->limit($limit)->offset($offset)->all();
		}
 		$re = ArrayHelper::toArray($re);	
		return $re;	

	}
*/	

	//获取一天里面的数据
	public  function getOneDayData($table,$condition){
		 $where = $condition['where'];
		 $order_by =  $condition['order_by'];
		 $limit = $condition['limit'];
		 $offset = $condition['offset'];
		$query_keyword  = $condition['query_keyword'];		
		$re = AuditLog::find()->from($table, "type")->where($where)->query($query_keyword)->orderBy(['create_time' => $order_by])->limit($limit)->offset($offset)->all();
 		$re = ArrayHelper::toArray($re);	
		return $re;	

	}


	
	//获取查询总数
	public  function getTotal($tables,$post){
			if(empty($tables)){
				return 0;	
			}
			foreach ($tables as $value) {
				 foreach ($value as &$v) {
				  	 $tables_new [] = $v;
				 } 
			}

			$condition = AuditLog::setWhere($post);
			$where = $condition[0];
			$query = $condition[1];
			$flag = $condition[2];
			$where_str = $condition[3];
			$query_keyword = $condition[4];
			$time_where = AuditLog::setTimeWhereByMore($post); //供统计总数使用
			if(count($where) > 0){
				$where_more = $where;
				$where_more[] = $time_where;
			}else{
				$where_more = $time_where;
			}
			if($flag == 0){
					return 0;
			}			 
			$re = AuditLog::find()->from($tables_new, "type")->where($where_more)->query($query_keyword)->Count();
			return $re;
	}
	
	//获取采集总数
	public function getCollectionTotal($tables,$post){
			if(empty($tables)){
				return 0;	
			}
			foreach ($tables as $value) {
				 foreach ($value as &$v) {
				  	 $tables_new [] = $v;
				 } 
			}
			$condition = AuditLog::setWhere($post);
			$query = $condition[1];
			$flag = $condition[2];
			$connect_num_field = $post['connect_num_field'];
			if($flag == 0){
				return 0;
			}			 
			$re = AuditLog::find()->from($tables_new, "type")->query($query)->addAgg('count','sum',["field" =>"$connect_num_field"])->count_ter();
			return $re;
	}
	
	//获取查询去重总数
	public function getDistinctTotal($tables,$post){
			if(empty($tables)){
				return 0;	
			}
			foreach ($tables as $value) {
				 foreach ($value as &$v) {
				  	 $tables_new [] = $v;
				 } 
			}
			$condition = AuditLog::setWhere($post);
			$query = $condition[1];
			$flag = $condition[2];
			$distinct_field = $post['distinct_field'];
			if($flag == 0){
				return 0;
			}			 
			$re = AuditLog::find()->from($tables_new, "type")->query($query)->addAgg('count','cardinality',["field" =>"$distinct_field"])->count_ter();
			return $re;
	}
	
	//导出数据
	public function getExplode($tables,$post){
		$file_info = AuditLog::getExportFileInfo($post['data_type']);
		$file_path = $file_info[0];
		$file_name = $file_info[1];
		$re['path_export'] =$file_path;
		$re['file_export'] =$file_name;
		if(empty($tables)){
			    $re['result'] =2;
				return $re;	
		}
		if($post['export_name'] == ''){
				$re['result'] =3;
				return $re;	
		}else{
			$fields_tmp = explode(',',$post['export_name']);
			foreach ($fields_tmp as $v) {
			 	 $need_fields[$v] = $v;
			} 
		}

		//获取要返回的字段
		$fields = AuditLog::getFileds($post['data_type']);
		$max = $post['max'];
		$need_title = [];
		foreach($need_fields as $v){
				if(isset($fields[$v])){
					$need_title[] = $fields[$v];	
				}else{
					$re['result'] =5;
					return $re;
				}
		}
		
		$title[0] = $need_title;
		
		$export_obj = new File();
		$export_obj->writeDataToCsv($file_path,$file_name,$title);
		$flag = 10000;
		
		$post['page_size'] = $flag;
		$post['page'] = 1;
		$re['result'] =2;
		$export_obj = new File();
		for($i=0; $i< $max; $i=$i+$flag){
				$post['page'] = $i+1;
				$data = AuditLog::getData($tables,$post);
				$re['desc'] = $data['desc']; 
				if(count($data['data']) > 0){
					$data2 = AuditLog::setData($data, $need_fields,$post['data_type'],$post['act']);
					$export_obj->writeDataToCsv($file_path,$file_name,$data2['data']);
					$re['result'] =1;
					if(count($data) < $flag){
						 break;
					}
				}else{
					break;	
				}
				unset($data2);
				unset($data);
		}
		return $re;		
	}
	
	
	public function setWhere($post){
		$where = array();
		$query = array();
		$query_keyword = array();
		$where_str = '';
		$desc = [];
		$flag = 1; //有些匹配不到数据的，显示返回
		$base = new Base();
		$ServiceInfo = new ServiceInfo();
		if(isset($post['factory_code']) && $post['factory_code'] != '_all'){
			$where[] = ["factory_code" => $post['factory_code']];
			$query[] = ["term" => ["factory_code" => $post['factory_code']]];
			$where_str .= "factory_code:".$post['factory_code'];
			$desc[] = "厂商机构代码：".$post['factory_code'];
		}
		if(isset($post['vpact_type_id']) && $post['vpact_type_id'] != ''){
			$account_arr = explode(",", $post['vpact_type_id']);
			if($post['data_type'] == 'mac_ap' || $post['data_type'] == 'mac'){
				$where[] = array("in","identitication_type", $account_arr);
				$query[] = ["in" => ["identitication_type" =>  $account_arr]];
			}else{
				$where[] = array("in","app_type", $account_arr);
				$query[] = ["in" => ["app_type" =>  $account_arr]];
			}
			$where_str .= "vpact_type_id:".$post['vpact_type_id'];
			$desc[] = "协议类型：".$post['vpact_type_id'];
		}
		if(isset($post['auth_account']) && $post['auth_account'] != ''){
			$where[] =["auth_account" => trim($post['auth_account'])];
			$query[] = ["auth_account" => trim($post['auth_account'])];
			$where_str .= "auth_account:".$post['auth_account'];
			$desc[] = "认证帐号：".$post['factory_code'];
		}
		if(isset($post['app_account_id']) && $post['app_account_id'] != ''){
			$where[] =["app_account_id" =>trim($post['app_account_id'])];
			$query[] = ["app_account_id" => trim($post['app_account_id'])];
			$where_str .="app_account_id:". $post['app_account_id'];
			$desc[] = "虚拟帐号：".$post['app_account_id'];
		}
		
		if(isset($post['mac']) && $post['mac'] != ''){
			$where[] =["mac" => str_replace(":","-",strtoupper(trim($post['mac'])))];
			$query[] = ["mac" =>  str_replace(":","-",strtoupper(trim($post['mac'])))];
			$where_str .="mac:". $post['mac'];
			$desc[] = "mac：".$post['mac'];
		}
		if(isset($post['area_ids']) && $post['area_ids'] != ''){
			$area_array = explode(",", $post['area_ids']);
			$area_code_array = AuditLog::getAreaCodes($area_array);
			$where[] = array("in", 'area_code', $area_code_array);
			$query[] = ["in" => ["area_code" => $area_code_array]];
			$where_str .= "area_code:".$post['area_ids'];
			$desc[] = "场所编码：".$post['area_ids'];
		}else{ //校验区域权限
			$area_array = array();
			$area_code_array = AuditLog::getAreaCodes($area_array);
			if(!empty($area_code_array)){
				$where[] = array("in", 'area_code', $area_code_array);
				$query[] = ["in" => ["area_code" => $area_code_array]];
				$where_str .= "area_code:".$post['area_ids'];
			}
		}
		if(isset($post['service_name']) && $post['service_name'] != '')
		{
			$service_names = ServiceInfo::getServicesByName($post['service_name']);
			$where_str .= "service_name:".$post['service_name'];
			$desc[] = "场所名称为".$post['service_name'];
			if( !empty($service_names)){
				$where[] = ["in", "service_code", $service_names];
				$query[] = ["in" => ["service_code" =>  $service_names]];
			}else{
				$flag = 0;	
			}
		}
		
		if(isset($post['keyword']) && $post['keyword'] != ''){
			$keyword = trim($post['keyword']);
			$desc[] = "关键字为：".$post['keyword'];
			if($post['data_type'] == 'mac_ap'){
				//$where[] = ["or",["mac" => strtoupper(trim($post['keyword']))], ["access_ap_mac" => strtoupper(trim($post['keyword']))],["identitication_account" => strtoupper(trim($post['keyword']))]];
				//$query[] = ["or" => [["term" => ["mac" => strtoupper(trim($post['keyword']))]],["term" => ["access_ap_mac" => strtoupper(trim($post['keyword']))]],["term" => ["identitication_account" => strtoupper(trim($post['keyword']))]]]];
				$wildFieldArr = ["mac","access_ap_mac","identitication_account"];
				$should = [];  
           		 foreach ($wildFieldArr as $field){
		                $whereOpt = [
		                    "wildcard" => [
		                        $field => "*$keyword*"
		                    ]
		                ];
		                $should[] = $whereOpt;
           		 }
	            $query[] = [
	                'bool' => [
	                    "should"=>$should
	                 ]
	            ];
	           
				
				$where_str .= "keyword:". $keyword;
				
			}else if($post['data_type'] == 'internet_log'){
				$wildFieldArr = [
		            "mac","app_account_id","auth_account","from_nickname","to_nickname","content","url","keyword", "username","bbs_topic","subject","user_account","message","mail_from","rcpt_to","mail_subject"
       		 	];
				$should = [];  
				
           		 foreach ($wildFieldArr as $field){
		                $whereOpt = [
		                    "wildcard" => [
		                        $field => "*$keyword*"
		                    ]
		                ];
		                $should[] = $whereOpt;
           		 }
	            $query[] = [
	                'bool' => [
	                    "should"=>$should
	                 ]
	            ];
				
				$where_str .= "keyword:". $keyword;
			}
			 $query_keyword =  [
	                'bool' => [
	                    "should"=>$should
	                 ]
	       ];
			
		}
		$desc[] = "时间范围：".$post['begin_time']."~".$post['begin_time']."";
		if(count($query) > 0){
			//$where[] = array("between", "create_time", str_replace(' ', 'T', $post['begin_time']), str_replace(' ', 'T', $post['end_time']));
			$query[] = ["range" => ["create_time" => ["gte"=>str_replace(' ', 'T', $post['begin_time']),"lte" => str_replace(' ', 'T', $post['end_time'])]]];
			array_unshift($where, "and");
			$query = ["and" => $query];
			$where_str .=  "time:". $post['begin_time'].$post['end_time'];
		}else{
			//$where = array("between", "create_time", str_replace(' ', 'T', $post['begin_time']), str_replace(' ', 'T', $post['end_time']));
			$query = ["range" => ["create_time" => ["gte"=> str_replace(' ', 'T', $post['begin_time']),"lte" => str_replace(' ', 'T', $post['end_time'])]]];
			$where_str .= "time:". $post['begin_time'].$post['end_time'];
		}
		
		return array($where,$query,$flag,$where_str,$query_keyword,$desc);
		
	}
	
	//设置时间条件，带时间条件es会花费比较多的时间
	public function setTimeWhere($table,$post){
	
		 foreach ($table as $v) {
		  	 $day = str_replace("_","-",substr($v, -11,10));
		 }
		 if(isset($day) && $day !=''){
		 	  $start_time = $day." 00:00:00";
		 	  $end_time = $day." 23:59:59";
		 }
		 if($post['begin_time'] == $start_time && $post['end_time'] == $end_time){ //同一天时间，默认时间
		 		return array(); 
		 }else{
		 		$post_day_start = substr($post['begin_time'], 0,10);
		 		$post_day_end = substr($post['end_time'], 0,10);
		 		if($post_day_start == $post_day_end){
		 				return array("between", "create_time", str_replace(' ', 'T', $post['begin_time']), str_replace(' ', 'T', $post['end_time']));
		 		}else if($day != $post_day_end && $day != $post_day_end){ //开始时间和结束时间的中间
		 			   return array();
		 		}else if($post['begin_time'] == $start_time &&  $post_day_start != $post_day_end){
						return array();	 			
		 		}else if($post['end_time'] == $end_time &&  $post_day_start != $post_day_end){
						return array();	 			
		 		}else{

		 			   return array("between", "create_time", str_replace(' ', 'T', $post['begin_time']), str_replace(' ', 'T', $post['end_time']));	
		 		}
		 } 
		 
	}
	
	//设置时间条件，供联多个索引查询使用
	
	public function setTimeWhereByMore($post){
		return  $where = array("between", "create_time", str_replace(' ', 'T', $post['begin_time']), str_replace(' ', 'T', $post['end_time']));
	}
	
	
	public function setData($res, $fields,$data_type,$act){

		$data = array();
		if(empty($res)){
			return $data;
		}
		//获取查询记录的相关场所信息
		$service_info = ServiceInfo::getServiceInfo($res['data']);		
		//获取查询记录的相关设备信息
		$equipment_info = EquipmentInfo::getEquipmentInfo($res['data']);		
		//获取所有的厂商信息
		$factory_names = Factory::getFactoryImfor();	
		//获取所有的终端厂商信息
		$terminal_company_info = TerminalCompany::get($res['data']);	
		//获取所有的终端厂商信息
		$auth_type_info = AuthType::getAutTypeByCode($res['data']);	
		//print_R($auth_type_info);
		//获取所有协议类型信息
		$account_type = json_decode(Yii::$app->cache->get('vp_type'),true);
		if($account_type == false){
				$account_type = VpAccountType::getType();	
				Yii::$app->cache->set('vp_type',json_encode($account_type),2592000);
		}
		//获取通讯协议类型
		$protocol_info = Protocol::getProtocol();
		$short_content_arr = AuditLog::getShortContent($data_type);
		$re = $res['data'];
		$i=0;

		foreach($re as $key => $val){
				foreach($fields as $field_key => $field_title){

						$data[$i][$field_key] 		= (isset($val[$field_key]) && $val[$field_key] !='')  ? $val[$field_key] : "-";
						if($field_key == 'equipment_name'){
							$data[$i][$field_key]	= isset($equipment_info[$val['equipment_code']][$field_key]) ? $equipment_info[$val['equipment_code']][$field_key] : "-";
						}
						if($field_key == 'service_name'){
							$data[$i][$field_key]	= isset($service_info[$val['service_code']]) ? $service_info[$val['service_code']] : "-";
						}
						if($field_key == 'factory_name'){
							$data[$i][$field_key]	= isset($factory_names[$val['factory_code']]) ? $factory_names[$val['factory_code']] : "-";
						}
						if($field_key == 'ssid'){
							
							$data[$i][$field_key]	= isset($val[$field_key])? CommonHelper::ssidDecode($val[$field_key]) : '-';
						}
						if($field_key == 'create_time' || $field_key == 'end_time'){
							$data[$i][$field_key]	= isset($val[$field_key])?  str_replace('T', ' ', $val[$field_key]): '-';
						}
						if($field_key == 'identitication_type'){					
								//$data[$i][$field_key] 	= isset($account_type[$val[$field_key]]) ? $account_type[$val[$field_key]] : '-';
								if(isset($val[$field_key])){
									$data[$i][$field_key] 	= isset($account_type[$val[$field_key]]) ? $account_type[$val[$field_key]] : '-';
								}else{ //ap日志没有虚拟账号类型 虚拟账号
									$data[$i][$field_key] 	= '-';
								}
						}
						if($field_key == 'app_type'){					
								//$data[$i][$field_key] 	= isset($account_type[$val[$field_key]]) ? $account_type[$val[$field_key]] : '-';
								if(isset($val[$field_key])){
									$data[$i][$field_key] 	= isset($account_type[$val[$field_key]]) ? $account_type[$val[$field_key]] : '-';
								}else{ //ap日志没有虚拟账号类型 虚拟账号
									$data[$i][$field_key] 	= '-';
								}
						}
						if($field_key == 'auth_type'){		
								$data[$i][$field_key] 	= isset($auth_type_info[$val[$field_key]]) ? $auth_type_info[$val[$field_key]] : '-';
						}
						if($field_key == 'short_content'){			
								//$data[$i][$field_key] 	= isset($val[$short_content_arr[$val['app_code']]]) ? $val[$short_content_arr[$val['app_code']]] : '-';
								if(isset($short_content_arr[$val['app_code']])){
									$data[$i][$field_key] 	= isset($val[$short_content_arr[$val['app_code']]]) ? $val[$short_content_arr[$val['app_code']]] : '-';
								}else{ 
									$data[$i][$field_key] 	= '-';
								}
						}
						if($field_key == 'ip' || $field_key == 'src_ipv4' || $field_key =='dest_ip' ){					
								$data[$i][$field_key] 	= long2ip($val[$field_key]);
						}
						if($field_key == 'terminal_company'){
							$mac_pre = strtoupper(substr($val['mac'],0,8));
							$data[$i][$field_key]	= isset($terminal_company_info[$mac_pre]) ? $terminal_company_info[$mac_pre] : "-";
						}
						if($field_key == 'protocol_code'){
							
							 //$data[$i][$field_key]	= isset($protocol_info[$val[$field_key]]) ? $protocol_info[$val[$field_key]] : "-";
							 if(isset($val[$field_key])){
									$data[$i][$field_key]	= isset($protocol_info[$val[$field_key]]) ? $protocol_info[$val[$field_key]] : "-";
								}else{ 
									$data[$i][$field_key] 	= '-';
								}
						}
						if($field_key == 'data_type'){							
								$flag = substr($val['index'], 0, stripos($val['index'], '_'));
								if($flag == 'mac'){
									$data[$i][$field_key] 	= 'MAC日志';
								}else if($flag == 'ap'){
									$data[$i][$field_key] 	= 'AP日志';
								}else if($flag == 'internet'){
									$data[$i][$field_key] 	= '上网日志';
								}
						}
						if($act == "export" && $field_key == 'id'){
							 $data[$i][$field_key] 	= $i+1;
						}
				}
				$i++;
			}
			$arr['data'] = $data;
			$arr['total'] = $res['total'];
			$arr['desc'] = $res['desc'];
			unset($account_type);
			return $arr;
	}

	public function getAreaCodes($area_code_array){
		//获取当前登录用户的区域权限
		$identity = \Yii::$app->getUser()->getIdentity();
		$user_area_code = $identity?$identity->area_code:'';
		if($user_area_code == ''){
			  return $area_code_array;
		}else{
			$user_area_code_arr_tmp = explode(",", $user_area_code);	
			$user_area_code_arr = Areacode::getAreas($user_area_code_arr_tmp);
		}
		if(empty($area_code_array)){
				return $user_area_code_arr;
		}else{
				$area_ids_arr = $area_code_array;
		}
		$re_area_code = [];
		for($i=0; $i < count($area_ids_arr); $i++){
			if(in_array($area_ids_arr[$i], $user_area_code_arr)){
					$re_area_code[] = $area_ids_arr[$i];
			}
		}
		return $re_area_code;
	}

	/*******************************************************************
	 * $table_type: "mac"、"ap"、"internet"
	 * $start_time: 2016-12-27 17:30:56
	 * $end_time: 2016-12-27 17:30:56
	 * @return array $tables['mac_2016_12_27'] = mac_2016_12_27*
	 *******************************************************************/
    public function getTables($table_type,$start_time,$end_time){
			if(!$table_type) return false;
  	 		$tables = array();
	   		if($start_time != "" && $start_time !=""){   
					$stime = strtotime(substr($start_time,0,10));
			        $etime = strtotime(substr($end_time,0,10));
			        for ($t=$etime;$t>=$stime;$t=$t-3600*24){
			            	$table_name = $table_type."_".date('Y_m_d',$t);
			                $tables[$table_name] = $table_name.'*';
			        }
			        return $tables;
	  	 	}else{
	  	 			return false;
	  	 	}
	}
	
	
	
	protected static function getShortContent($data_type){
		if($data_type == 'internet_log'){
				return [
			    //聊天--->content
			    '210000' => 'content',
			    //邮箱
			    '110000' => 'subject',
			    //微博
			    '140000' => 'title',
			    //博客
			    '150000' => 'account',
			    //bbs
			    '160000' => 'title',
			    //http
			    '100000' => 'url',
			    //搜索类
			    '237000' => 'keyword',
			    //购物，消费
			    '120000' => 'buy'
			];	
		}
		
		
	}
	
	public function getInfoById($condition)
	{			
			$id 				= $condition['id'];
			$index  		= $condition['index'];
			$data_type  = $condition['data_type'];
			$act  		   = $condition['act'];
			$app_type  	= $condition['app_type'];
			$flag = AuditLog::getAppTypeFlag($app_type);
			$fields = AuditLog::getFiledsByDetail($data_type,$flag);
			$fields_keys = array_keys($fields);
			$re = AuditLog::find()->from($index, "type")->where(["id" => $id])->all();
			$re['desc'] = "查看索引：".$index."，id为".$id."详情";
			$res = AuditLog::setData($re,$fields,$data_type,$act);
			$data = $res['data'][0];
			$info = array();
			foreach ($fields as $k=>$v) {
				if($k == 'index') continue;
			 	 $info[$k]['title'] = $v;
			 	 $info[$k]['content'] = isset($data[$k]) ? $data[$k] : "-";
			} 
			return $info;
	}
	
	public function getAppTypeFlag($app_type){
		$data = [
			'100000'	=> 'http',
			'110000'	=> 'mail', 
			'120000'	=> 'buy',
			'130000'	=> 'http',
			'140000'	=> 'weibo',
			'150000'	=> 'blog',
			'160000'	=> 'bbs',
			'180000'	=> 'video',
			'190000'	=> 'id',
			'200000'	=> 'game',
			'210000'	=> 'chat',
			'220000'	=> 'app',
			'230000'	=> 'app',
			'237000'	=> 'search',
			'240000'	=> 'http',
			'250000'	=> 'http',
		];
		if(isset($data[$app_type])){
			return $data[$app_type];
		}else{
			return false;
		}
		
	}

}
