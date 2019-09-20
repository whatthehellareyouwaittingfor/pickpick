<?php
namespace app\index\controller;
use think\Request;
use think\controller\Rest;
use think\Db;

class Tables extends Rest{
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
    public function fetch($name){
	    if(!empty($name)){
            $cdata=Db::query("select * from $name ORDER BY rand() LIMIT 1");
            $cname=Db::query("show columns from $name");
            $fields=[];
            foreach ($cname as $key=>$value){
                $fields[]=$value['Field'];
            }
            $data=[
                'data'=>$cdata,
                'field'=>$fields,
            ];
            return $data;
        }
    }
	
	public function search(){
		$param=Request::instance()->param();//获取当前请求的所有变量（经过过滤)
        if (!empty($param['data'])) {
            $columns = implode(',', $param['data']);
        }else {
            $columns = '';
        }
        if(!empty($columns)){
        if(!strstr($columns,'id')){
            $columns='id,'.$columns;
            $cdata=Db::query("select ".$columns." from ".$param['region']." ORDER BY rand() LIMIT 1");
            foreach (explode(',',$columns) as $key=>$value){
                $fields[]=$value;
            }
            $data=[
                'data'=>$cdata,
                'field'=>$fields,
            ];
        }}else{
            $cdata=Db::query("select * from ".$param['region']." ORDER BY rand() LIMIT 1");
            $cname=Db::query("show columns from ".$param['region']);
            $fields=[];
            foreach ($cname as $key=>$value){
                $fields[]=$value['Field'];
            }
            $data=[
                'data'=>$cdata,
                'field'=>$fields,
            ];
        }

        return $data;
    }
	public function update(){
	    $data = Db::query('select * from gms_userdata_history where userid=:id order by usedtime desc',['id'=>10086]);
	    return $data;
    }
	public function delete($id){
		
		$model = model('News');
		$rs=$model::get($id)->delete();
		if($rs){
			return json(["status"=>1]);
		}else{
			return json(["status"=>0]);
		}
    }
}
