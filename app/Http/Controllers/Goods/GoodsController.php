<?php
/**
 * 商品管理
 */
namespace App\Http\Controllers\Goods;

use App\Model\BasicAttrModel;
use App\Model\BasicAttrValueModel;
use App\Model\BrandModel;
use App\Model\CategoryModel;
use App\Model\SaleAttrModel;
use App\Model\SaleAttrValueModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GoodsController extends Controller
{
    /**
     * 商品添加
     */
    public function addGoods( Request $request){
        if( $request -> ajax()){
            $data = $request -> all();
            print_r($data);
        }else{
            //分类下拉
            $where = [
                'status'    => 1,
            ];
            $data = CategoryModel::where( $where ) -> get();
            if( empty( $data[0] ) ){
                $data =  [];
            }else{
                $data = CategoryModel::getCateInfo( $data );
            }


            //品牌下拉
            $where = [
                'brand_show'    =>  1
            ];
            $brand_data = BrandModel::where($where)->get();

            $info = [
                'title' =>  '商品添加',
                'data'  =>  $data,
                'brand_data'    =>  $brand_data
            ];

            return view( 'goods.add' , $info );
        }
    }

    /**
     * 基本属性查询
     */
    public function selectBasicAttr( Request $request )
    {
        $category_id = $request -> input( 'category_id' );
        $where = [
            'status'        =>  1,
            'category_id'   =>  $category_id,
        ];
        //属性
        $basic_attr = BasicAttrModel::where($where) -> get()->toArray();
        //属性值
        $basic_attr_value = BasicAttrValueModel::where($where) -> get()->toArray();
        foreach($basic_attr as $k => $v){
            $basic_attr[$k]['is_son'] = 0;
            foreach($basic_attr_value as $key =>$val){
                if($v['basic_id'] == $val['basic_id']){
                    $basic_attr[$k]['son'][] = $val;
                    $basic_attr[$k]['is_son'] = 1;
                }
            }
        }
        return $this -> dataJson( 1000 , '基本属性' , $basic_attr);
    }

    /**
     * 销售属性查询
     */
    public function selectSaleAttr( Request $request )
    {
        $category_id = $request -> input( 'category_id' );
        $where = [
            'status'        =>  1,
            'category_id'   =>  $category_id,
        ];
        //属性
        $sale_attr = SaleAttrModel::where($where) -> get()->toArray();
        //属性值
        $sale_attr_value = SaleAttrValueModel::where($where) -> get()->toArray();
        foreach($sale_attr as $k => $v){
            $sale_attr[$k]['is_son'] = 0;
            foreach($sale_attr_value as $key =>$val){
                if($v['sale_id'] == $val['sale_id']){
                    $sale_attr[$k]['son'][] = $val;
                    $sale_attr[$k]['is_son'] = 1;
                }
            }
        }
        return $this -> dataJson( 1000 , '销售属性' , $sale_attr);
    }
}
