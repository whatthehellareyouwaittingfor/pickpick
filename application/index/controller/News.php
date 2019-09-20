<?php
namespace app\index\controller;
use think\Request;
use think\controller\Rest;
use think\Db;

class News extends Rest{
	public function rest(){
        switch ($this->method){
			case 'get': 	//查询
				$this->read($name);
				break;
			case 'post':	//新增
				$this->add();
				break;
			case 'put':		//修改
				$this->update($id);
				break;
			case 'delete':	//删除
				$this->delete($id);
				break;
			
        }
    }
    public function read($name){
	    if(!empty($name)){
	        $name=$name.'%';
        }
        $data=Db::query("show tables like '$name'");
	    $array=[];
	    foreach ($data as $key=>$value){
	        $array[]=$value["Tables_in_offerstop (".$name.")"];
        }
		return $array;
    }
	
	public function add(){
		$param=Request::instance()->param();//获取当前请求的所有变量（经过过滤）
        foreach ($param['data'] as $key=>$value){
            Db::execute('insert into gms_userdata_history (userid,srctable,offerid,networkName,usedtime) values (:userid, :srctable, :offerid, :networkName, :usedtime)',['userid'=>10086,'srctable'=>$param['region'],'offerid'=>intval($param['id']),'networkName'=>$value['value'],'usedtime'=>date("Y-m-d H:i:s",time())]);
        }
        $data=[];
        return $data;
    }
	public function update($id){
		$model = model('News');
		$param=Request::instance()->param();
		if($model->where("id",$id)->update($param)){
			return json(["status"=>1]);
		}else{
			return json(["status"=>0]);
		}
    }
	public function delete(){
	    $data = Db::query('select * from gms_userdata_history where userid=:id order by usedtime desc',['id'=>10086]);
	    return $data;
    }
}
