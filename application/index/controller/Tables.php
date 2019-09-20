<?php
namespace app\index\controller;
use think\Request;
use think\controller\Rest;
use think\db;

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
            $cdata=Db::query("select * from $name ORDER BY rand() LIMIT 4");
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
            $cdata=Db::query("select ".$columns." from ".$param['region']." ORDER BY rand() LIMIT 4");
            foreach (explode(',',$columns) as $key=>$value){
                $fields[]=$value;
            }
            $data=[
                'data'=>$cdata,
                'field'=>$fields,
            ];
        }}else{
            $cdata=Db::query("select * from ".$param['region']." ORDER BY rand() LIMIT 4");
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
	public function update($id){
		$model = model('News');
		$param=Request::instance()->param();
		if($model->where("id",$id)->update($param)){
			return json(["status"=>1]);
		}else{
			return json(["status"=>0]);
		}
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
