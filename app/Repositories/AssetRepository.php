<?php
/**
 * Created by PhpStorm.
 * User: Tanguy
 * Date: 7/11/2016
 * Time: 10:58
 */

namespace App\Repositories;


use App\Contracts\RepositoryContract as RepositoryContract;
use App\Models\Asset;
use Carbon\Carbon;
use App\Models\Location as Location;
use App\Models\User as User;
use App\Models\Supplier as Supplier;
use App\Models\Statuslabel as Status;
use App\Models\AssetModel as Model;
use Illuminate\Support\Facades\DB;

class AssetRepository implements RepositoryContract
{
    public function create($asset)
    {
        $MySQLdatum = date('Y-m-d', strtotime($asset['purchase_date']));
        //GEBRUIK DB: .... -> insert ... want als je create functie van model gebruikt, ben je beperkt door je fillable van de model
        if(DB::table('assets')->insert([
                'name' => $asset['name'],
                'asset_tag' => $asset['asset_tag'],
                'model_id' => $asset['model_id'],
                'purchase_date' => $MySQLdatum,                         
                'purchase_cost' => $asset['purchase_cost'],
                'order_number' => $asset['order_number'],
                'notes' => $asset['notes'],
                'image' => $asset['image'],
                'user_id' => $asset['user_id'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null,
                'status_id' => $asset['status_id'],
                'archived' => null,
                'warranty_months' => $asset['warranty_months'],
                'depreciate' => null,
                'supplier_id' => $asset['supplier_id'],
                'requestable' => $asset['requestable'],
                'rtd_location_id' => $asset['rtd_location_id'],
                'accepted' => $asset['accepted'],
                'last_checkout' => null,
                'expected_checkin' => null,
                'company_id' => $asset['company_id'],
                'serial' => $asset['serial'],
                'physical' => $asset['physical']
            ])){
                return true;
            }
            else{
                return false;
            }
       }
    

    public function delete($id)
    {
        if($asset = Asset::where('id', $id))
        {
            $asset->delete();
            return true;
        }
         return false;
    }

    public function update($asset, $id)
    {
        $MySQLdatum = date('Y-m-d', strtotime($asset['purchase_date']));
       if(Asset::find($id))
        {
            var_dump($asset);
            print_r($asset["model_id"]);
            //DE RECORD ZOEKEN DIE MATCHT MET ID
            $var = Asset::find($id);

            //NIEUWE WAARDES INSERTEN ALS HET NIET NULL IS (DUS ALS DE WAARDE EFFECTIEF GECHANGED IS)
            if ($asset['name'] != null){
                $var->name = $asset['name'];
            }
            if ($asset['asset_tag'] != null){
                $var->asset_tag = $asset['asset_tag'];
            }
            if ($asset['model_id'] != 0){
                $var->model_id = $asset['model_id'];
            }
            if ($asset['status_id'] != 0){
                $var->status_id = $asset['status_id'];
            }
            if ($asset['order_number'] != null){
                $var->order_number = $asset['order_number'];
            }
            if ($asset['purchase_cost'] != 0){
                $var->purchase_cost = $asset['purchase_cost'];
            }
            if ($asset['purchase_date'] != null){
                $var->purchase_date = $MySQLdatum;
            }
            if ($asset['notes'] != null){
                $var->notes = $asset['notes'];
            }
            if ($asset['image'] != null){
                $var->image = $asset['image'];
            }
            if ($asset['user_id'] != 0){
                $var->user_id = $asset['user_id'];
            }
            if ($asset['status_id'] != 0){
                $var->status_id = $asset['status_id'];
            }
            if ($asset['physical'] != 0){
               $var->physical = $asset['physical'];
            }
            if ($asset['warranty_months'] != null){
                $var->warranty_months = $asset['warranty_months'];
            }
            if ($asset['supplier_id'] != 0){
                 $var->supplier_id = $asset['supplier_id'];
            }
            if ($asset['requestable'] != null){
                $var->requestable = $asset['requestable'];
            }
            if ($asset['rtd_location_id'] != 0){
                $var->rtd_location_id = $asset['rtd_location_id'];
            }
            if ($asset['accepted'] != null){
                $var->accepted = $asset['accepted'];
            }
            if ($asset['serial'] != null){
                $var->serial = $asset['serial'];
            }
            if ($asset['company_id'] != 0){
                $var->company_id = $asset['company_id'];
            }
            
            //AANGEPASTE RECORD SAVEN
            $var->save();
            return true;
        }
        else
            return false;
    }

    public function getById($id)
    {
        if (Asset::find($id)){
        $var =  Asset::find($id);
         //_________________USER OMVORMEN_________________________________
            if (!$var["user_id"] == null){
                $voornaam = User::where('id', $var["user_id"])->get()[0]["first_name"];
                 $achternaam = User::where('id', $var["user_id"])->get()[0]["last_name"];
                 $string = $voornaam . " " . $achternaam;
                $var["user"] = $string;
               
            } 
            else{
                $var["user"] = "unknown user";
            }

        //_________________LOCATIE OMVORMEN_________________________________
            if (!$var["rtd_location_id"] == null){
                $var["location"] = Location::where('id', $var["rtd_location_id"])->get()[0]["name"];
                unset($var["rtd_location_id"]);
            }
            else{
            $var["location"] = "unknown location";  
            }
        //_________________SUPPLIER OMVORMEN_____________________________________
            
        if (!$var["supplier_id"] == null){
            $naam = Supplier::where('id', $var["supplier_id"])->get()[0]["name"];
            $var["supplier"] = $naam;       
        } 
        else{
            $var["supplier"] = "unknown supplier";
        }
        //_________________STATUS OMVORMEN_________________________________
        if (!$var["status_id"] == null){
            $naam = Status::where('id', $var["status_id"])->get()[0]["name"];
            $var["status"] = $naam;
           
        } 
        else{
            $var["status"] = "unknown status";  
        }
        //_________________MODEL OMVORMEN_________________________________
        if (!$var["model_id"] == null){
            $naam = Model::where('id', $var["model_id"])->get()[0]["name"];
            $var["model"] = $naam;
           
        } 
        else{
            $var["model"] = "unknown model";  
        }
        //___________________VERWIJDEREN VAN IDS UIT ARRAY, NIET NODIG______________
            unset($var["user_id"]);
            unset($var["rtd_location_id"]);
            unset($var["supplier_id"]);
            unset($var["status_id"]); 
            unset($var["model_id"]);

        return $var;
    }

    else {
        return  "Asset not found";}
    }

    public function getAll()
    {
        $var =  Asset::all();
        for ($i=0; $i < count($var); $i++) { 
             //_________________USER OMVORMEN_________________________________
            if (!$var[$i]["user_id"] == null){
                $voornaam = User::where('id', $var[$i]["user_id"])->get()[0]["attributes"]["first_name"];
                 $achternaam = User::where('id', $var[$i]["user_id"])->get()[0]["attributes"]["last_name"];
                 $string = $voornaam . " " . $achternaam;
                $var[$i]["user"] = $string;
               
            } 
            else{
                $var[$i]["user"] = "unknown user";
               
            }
            //_________________LOCATIE OMVORMEN_________________________________
             if (!$var[$i]["rtd_location_id"] == null){
                $naam = Location::where('id', $var[$i]["rtd_location_id"])->get()[0]["attributes"]["name"];
                $var[$i]["location"] = $naam;
            } 
            else{
                $var[$i]["location"] = "unknown location";
            }
             //_________________SUPPLIER OMVORMEN_____________________________________
            
            if (!$var[$i]["supplier_id"] == null){
                $naam = Supplier::where('id', $var[$i]["supplier_id"])->get()[0]["attributes"]["name"];
                $var[$i]["supplier"] = $naam;
               
            } 
            else{
                $var[$i]["supplier"] = "unknown supplier";
            }
            //_________________STATUS OMVORMEN_________________________________
             if (!$var[$i]["status_id"] == null){
                $naam = Status::where('id', $var[$i]["status_id"])->get()[0]["attributes"]["name"];
                $var[$i]["status"] = $naam;
               
            } 
            else{
                $var[$i]["status"] = "unknown status";  
            }
            //_________________MODEL OMVORMEN_________________________________
             if (!$var[$i]["model_id"] == null){
                $naam = Model::where('id', $var[$i]["model_id"])->get()[0]["attributes"]["name"];
                $var[$i]["model"] = $naam;
               
            } 
            else{
                $var[$i]["model"] = "unknown model";  
            }

            //___________________VERWIJDEREN VAN IDS UIT ARRAY, NIET NODIG______________
            unset($var[$i]["rtd_location_id"]);
            unset($var[$i]["user_id"]); 
            unset($var[$i]["supplier_id"]);
            unset($var[$i]["status_id"]); 
            unset($var[$i]["model_id"]); 
        }      
       return $var;
    }

}