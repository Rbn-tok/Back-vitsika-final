<?php

namespace App\Http\Controllers;

use App\Models\Alerte;
use App\Models\Media;
use App\Models\Pollution;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AlerteController extends Controller
{
    //Alerter l'admin d'une pollution
    public function alerterPollution(Request $request){
       
       //insetion texte
       $alerte = new Alerte();

       $alerte->observation = $request->input("observation");
       $alerte->id_pollution = $request->input("id_pollution");
       $alerte->id_user = $request->input("id_user");
       $alerte->id_region = $request->input("id_region");
       $alerte->id_niveau = $request->input("id_niveau");

       $alerte->save();

       //insertion medias de l'alerte
       $imageName = "";
       $imageExtension = ""; 

       if(! is_null($request->file('media_alerte')))
       {
           $photos=$request->file('media_alerte');
           $imageExtension=$photos->getClientOriginalExtension();
           $imageName = time();
           $imagOriginal = $imageName.'.'.$imageExtension;
           
           $photos->move('images', $imagOriginal);
       }    

        //get last alerte id
       $id_alerte = DB::table("alertes")->orderByDesc("id")->first()->pluck("id");
       $media = new Media();
       $media->type         = $request->input("type_media");
       $media->chemin       = $imageName.'.'.$imageExtension;
       $media->id_alerte    = $id_alerte;

    }
    //liste des niveaux d'alerte
    public function getAllNivAlerte(){
      $alertes = Alerte::all();
      return $alertes;

    }

    //liste des niveaux d'alerte
    public function getAllPollution(){
        $alertes = Pollution::all();
        return $alertes;
  
      }

    public function getPollutionByRegion(Request $request){
        $pollution = DB::table('alertes')
                        ->join('alerte_pollutions','alertes.id','=','alerte_pollutions.id_alerte')
                        ->join('pollutions','pollutions.id','=','alerte_pollutions.id_pollution')
                        ->join('regions','regions.id','=','alertes.id_region')
                        ->select('pollutions.pollution',DB::raw('count(alertes.id) as nb'))
                        ->groupBy('pollutions.pollution')
                        ->where('regions.region','=',$request->input('region'))
                        ->get();
        return json_encode($pollution);
    }
}
