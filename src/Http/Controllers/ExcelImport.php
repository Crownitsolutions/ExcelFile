<?php

namespace lct\Excel\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use lct\Excel\Http\Controllers\SimpleXLSX;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
class ExcelImport extends Controller
{
    //

    public function index(){
  
        return view("Excel::index");
      

    }

    public function add(Request $request){
        $request->validate([
            'fileToUpload' => 'required|file|max:5120|mimes:xlsx,xls',
        ]);
              // Variable Create and array start
              $product_counts = 0;
              $current_date = date('Y-m-d H:i:s');
              $current_year_id = 0;
              $budgets_id = 0;
              $row = 1;
              $department_id = 0;
              $sub_units = 0;
              $category_id = 0;
              $chart_id = 0;
              $category_order = 1; 
              $product_id = 0;
              $department_column_start = 10;
              $department_column_end = 22;
              $department_column_type_increament = 10;
              $department_column_type_increament_updated = 10;
              $organization_unit_id = 1;
              $product_Image = "product.png";
              $category_Image="category.png";
              $category_Table = [];
              $Product_Table = [];
              $departments_data = [];
              $departments_sub_unit = [];
              $departments_sub_unit_new = [];
              $departments_sub_unit_new_phone = [];
              $departments_sub_unit_new_Address = [];
              $departments_sub_unit_new_city = [];
              $departments_sub_unit_new_state = [];
              $departments_sub_unit_new_zip = [];
              $departments_sub_unit_new_complete = [];
              $category_product=[];
              $budget_chart = [];
              $chart_part1 = array();
              $chart = [];
              $category_Name_Checked = [
                "OPERATING INCOME",
                 "GRANT INCOME",
              "INCOME FROM BANK (PROFIT-PLS A/C)",
              "OPERATING EXPENSES",
              "SALARIES, WAGES & BENEFITS",
              "RENT, RATES & TAXES",
              "Vehicle Rent",
              "REPAIR & MAINTENANCE",
              "INSURANCE CHARGES",
              "PRINTING & STATIONERY",
              "I.T. SUPPORT",
              "DEPRECIATION & AMORTIZATION",
              "COMMUNICATION EXPENSES",
              "UTILITY EXPENSES",
              "NEWSPAPER & OTHERS",
              "BANK CHARGES",
              "TRAVEL & SUBSISTENCE",
              "Food and Beverages",
              "Medical Supplies",
              "Land & Building",
              "Water Purification",
              "Farming",
              "Housekeeping and Disposables",
              "EVENTS",
              "ELECTRICAL & GAS EQUIPMENT",
              "INTERIOR FURNISHING & FURNITURE",
              "FUEL EXPENSE",
              "OTHER EXPENSES",
              "SHARE CAPITAL & RESERVES",
              "SHARE CAPITAL",
              "RESERVES",
              "UN-APPROPRIATED PROFITS/ACCUMULATED LOSSES",
              "SURPLUS ON REVALUATION OF FIXED ASSETS",
              "LIABILITIES",
              "NON-CURRENT LIABILITIES",
              "LONG TERM PAYABLES",
              "CURRENT-LIABILITIES",
              "CREDITORS",
              "ACCCRUED LIABILITIES",
              "ADVANCES",
              "INCOME TAX PAYABLE",
              "SHORT TERM FINANCING",
              "SECURITY DEPOSITS",
              "ASSETS",
              "NON-CURRENT ASSETS",
              "PROPERTY & EQUIPMENT",
              "ACCUMULATED DEPRECIATION",
              "LONG TERM INVESTMENTS",
              "LONG-TERM LOANS & ADVANCES",
              "CURRENT ASSETS",
              "STORES & LOOSE TOOLS",
              "DEBTORS",
              "SHORT TERM INVESTMENTS",
              "ADVANCE INCOME TAX",
              "ADVANCE, DEPOSITS & PREPAYMENTS",
              "CASH AND BANK BALANCES",
              ];
             // Variable Create and array end 
             // Budget Max Id 
               $year =  \Carbon\Carbon::now()->format('Y'); 
               $budget_heighest_values = DB::table('budgets')->where('year','=',$year)->max('id');
               if ($budget_heighest_values != null) { 
                  $current_year_id = $budget_heighest_values;
               }
               // Chart Max ID
               $chart_id_heighest_values= DB::table('charts')->max('id');;
               if ($chart_id_heighest_values != null) { 
                  $chart_id = $budget_heighest_values;
               }
               // Department Max ID
               $department_heighest_values= DB::table('departments')->max('id');;
               if ($department_heighest_values != null) { 
                  $department_id = $department_heighest_values;
               }
      
              // Sub unit Max ID
               $sub_units_heighest_values= DB::table('sub_units')->max('id');;
              if ($sub_units_heighest_values != null) { 
                  $sub_units = $sub_units_heighest_values;
                        }

               // Product Max ID
               $product_heighest_values= DB::table('products')->max('id');;
               if ($product_heighest_values != null) { 
                $product_id = $product_heighest_values;
                         }
      
          // Category Max ID
          $category_id_heighest= DB::table('categories')->max('id');
          if ($category_id_heighest != null) { 
              $category_id = $category_id_heighest;
                    }
                    $category_id_heighest1= DB::table('categories')->max('order');
                    if ($category_id_heighest1 != null) { 
                        $category_order= $category_id_heighest1;
                              }
      
                             
             // return "budget id=".$current_year_id."chart ID=".$chart_id."department ID=".$department_id."sub unit id=".$sub_units."category id=".$category_id ."," .$category_order; 
      
        $xlsx = SimpleXLSX::parse($request->file('fileToUpload')); // Read Excel file
        if ($xlsx) {
             // Loop for Rows Read
          foreach($xlsx->rows() as $key => $rows){
            if($row == 1){ $row++; continue; } // skip First Row
            //department Table
            else if ($row == 2){  
              for($i=$department_column_start; $i < $department_column_end; $i++ ){
                $sub_units =  $sub_units + 1; 
                $department_id = $department_id + 1;

             

                array_push($departments_data,["code"=>str_replace(' ', '-',$rows[$i]),"name"=>$rows[$i],"slug"=>str_replace(' ', '-',$rows[$i]),"sub_unit_id"=>$sub_units,"created_at"=>$current_date,"updated_at"=>$current_date]);
               // array_push($departments,"('".str_replace(' ', '-',$rows[$i])."'" ."," ."'".$rows[$i]."'".",". "'".str_replace(' ', '-',$rows[$i])."'".",".$sub_units.",'".$current_date."'".","."'".$current_date."'".")");
                array_push($departments_sub_unit,["code"=>str_replace(' ', '-',$rows[$i]),"name" =>$rows[$i],"slug"=>str_replace(' ', '-',$rows[$i])]); 
                array_push($chart_part1,array($rows[$i],$department_id,$sub_units));

              }
              $row++;
            }
            // Sub unit Table start 
            else if ($row == 3){
                foreach($departments_sub_unit as $value){  
                    array_push($departments_sub_unit_new,array_merge($value,["type"=>$rows[$department_column_type_increament],"organization_unit_id"=>$organization_unit_id,"image"=>"sub-unit.png"]));   
                    $department_column_type_increament = $department_column_type_increament + 1;      
                }
                $department_column_type_increament = $department_column_type_increament_updated;
                 // Budget Table
                
                $row++;
            }else if ($row == 4){
                foreach($departments_sub_unit_new as $value){   
                   
                  array_push($departments_sub_unit_new_phone,array_merge($value,["phone"=>"+".$rows[$department_column_type_increament]]));
                  $department_column_type_increament = $department_column_type_increament + 1;
                  
                }
                $department_column_type_increament = $department_column_type_increament_updated;
              $row++;
            }
            else if ($row == 5){
                foreach($departments_sub_unit_new_phone as $value){    
                   
                  array_push($departments_sub_unit_new_Address,array_merge($value,["address"=>$rows[$department_column_type_increament]]));
                  $department_column_type_increament = $department_column_type_increament + 1;
                  
                }
                $department_column_type_increament = $department_column_type_increament_updated;
              $row++;
            }else if ($row == 6){
                foreach($departments_sub_unit_new_Address as $value){    
                    
                  array_push($departments_sub_unit_new_city,array_merge($value,["city"=>$rows[$department_column_type_increament]]));
                  $department_column_type_increament = $department_column_type_increament + 1; 
                }
                $department_column_type_increament = $department_column_type_increament_updated;
              $row++;
            }else if ($row == 7){
                foreach($departments_sub_unit_new_city as $value){   
                    
                  array_push($departments_sub_unit_new_state,array_merge($value,["state"=>$rows[$department_column_type_increament]]));
                  $department_column_type_increament = $department_column_type_increament + 1; 
                }
                $department_column_type_increament = $department_column_type_increament_updated;
              $row++;
            }else if ($row == 8){
                foreach($departments_sub_unit_new_state as $value){   
                    
                  array_push($departments_sub_unit_new_zip,array_merge($value,["zip"=>$rows[$department_column_type_increament]]));
                  $department_column_type_increament = $department_column_type_increament + 1; 
                }
                $department_column_type_increament = $department_column_type_increament_updated;
              $row++;
            }else if ($row == 9){
                foreach($departments_sub_unit_new_zip as $value){    
                  array_push($departments_sub_unit_new_complete,array_merge($value,["country"=>$rows[$department_column_type_increament],"created_at"=>$current_date,"updated_at"=>$current_date]));
                  $department_column_type_increament = $department_column_type_increament + 1; 
                }
                $department_column_type_increament = $department_column_type_increament_updated;
              $row++;
            }
            // sub unit Table End
            else  if($row == 10){ $row++; continue; } // Skip Row 
            // All Rows Convert in Array
            else{
              if($current_year_id == 0){
                $newyear = $rows[3];
                $data = [ 'year' =>$newyear , 'slug' => $newyear, 'created_at'=>$current_date ,'updated_at'=>$current_date ];
                $current_year_id  = DB::table('budgets')->insertGetId( $data );
                
            }      
                $newcells[] = $rows;
              
            }
          }
          // Read Excel Cell in Array
          foreach($newcells as $cell){
            $flag = "";
            // Category Table
         foreach($category_Name_Checked as $value_checked){
           if($cell[1] == $value_checked){
             $category_id  = $category_id + 1;
             $category_order = $category_order +1;

             $Cell_data =["code"=>$cell[0],"name"=>$cell[1],"slug"=>str_replace(' ', '-',$cell[1]),"excerpt"=>$cell[6],"order"=>$category_order,"image"=>$category_Image,"display"=>'1',"created_at"=>$current_date,"updated_at"=>$current_date];
              array_push($category_Table,$Cell_data);
              $flag = $value_checked;
              // Budget Chart Table
             
              
              for($i=0; $i<count($chart_part1); $i++ ){
                if($chart_part1[$i][0] == $cell[8]){
                  $chart_id = $chart_id + 1;
                  array_push($chart,["code"=>$cell[7],"slug"=>$cell[7],"organization_unit_id"=>$organization_unit_id,"sub_unit_id"=>$chart_part1[$i][2],"department_id"=>$chart_part1[$i][1],"category_id"=>$category_id,"created_at"=>$current_date,"updated_at"=>$current_date]);
                  array_push($budget_chart,["budget_id"=>$current_year_id,"chart_id"=>$chart_id,"budget"=> $cell[2],"total_budget"=>$cell[2]]);
                }
                
           }
            

              break;
            
             }
           
         }
         // Category Row Skip
         if($cell[1] == $flag){
           continue;
         }
         // Product Table
         else{
           $product_id = $product_id  +1;
           $quantity = 1;
           array_push($category_product,["category_id"=>$category_id,"product_id"=>$product_id]);
           $Cell_data_product = ["sku"=>$cell[0],"name"=>$cell[1],"slug"=>str_replace(' ', '-',$cell[1]),"description"=>$cell[4],"order" =>$cell[5],"price"=>$cell[2],"quantity"=>$quantity,"image"=>$product_Image,"created_at"=>$current_date,"updated_at"=>$current_date];
           array_push($Product_Table,$Cell_data_product);
           continue;
         }

         
        
       }

        }
    
/*
DB::transaction(function () {
          DB::table('sub_units')->insert($departments_sub_unit_new_complete);
          DB::table('departments')->insert($departments_data);
          DB::table('categories')->insert($category_Table);
          DB::table('products')->insert($Product_Table);
          DB::table('category_product')->insert($category_product);
          DB::table('charts')->insert($chart);
          DB::table('budget_chart')->insert($budget_chart);
      });
*/
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
         DB::beginTransaction();
        try {
         $sql_subunit          =  DB::table('sub_units')->insert($departments_sub_unit_new_complete);
         $sqldeparment         =  DB::table('departments')->insert($departments_data);
         $sqlcategories        =  DB::table('categories')->insert($category_Table);
         $sqlproduct           =  DB::table('products')->insert($Product_Table);
         $sqlcategoriesproduct =  DB::table('category_product')->insert($category_product);
         $sqlchart             =  DB::table('charts')->insert($chart);
         $sqlbudgetchart       =  DB::table('budget_chart')->insert($budget_chart);

         if($sql_subunit && $sqldeparment && $sqlcategories && $sqlproduct && $sqlcategoriesproduct && $sqlchart && $sqlbudgetchart){
           DB::commit();
           Session::flash('message', 'Data Has Been Inserted Successfully!!');
           DB::statement('SET FOREIGN_KEY_CHECKS=1;');
         }else{
          DB::rollback();
          Session::flash('Alert', 'Data Has Not Been Inserted Please Try Again!!'); 
         }
         return redirect()->back();
    }catch (\Exception $e) {
         DB::rollback();
         Session::flash('Alert', 'Data Has Not Been Inserted Please Try Again!!'); 
         return redirect()->back();
    }


      
        
        
    }
}
