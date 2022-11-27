<?php

namespace App\Http\Controllers;

use App\Models\Commentaire;
use App\Models\Htag;
use App\Models\Like;
use App\Models\Media;
use App\Models\Publication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PublicationController extends Controller
{
    
  
    //Creer un publication
    public function creerPublication(Request $request){
        try{

        $id_tag = "";
     
        
        $htag = new Htag();
        $htag->categ = $request->input("categ");
        $htag->save();

        $id_tag = DB::table("htags")->count();

        $pub = new Publication();
        $pub->description  = $request->input("description"); 
        $pub->date_pub     = $request->input("date_pub"); 
        $pub->id_tag       = $id_tag;
        $pub->id_pollution = $request->input("id_pollution") ; 
        $pub->id_region    = "3";
        $pub->id_user      = "1";
        $pub->id_alerte    = "1";

        $pub->save();


    //    //insertion image de la publication
       $imageName = "";
       $imageExtension = ""; 

       if(! is_null($request->file('media_pub')))
       {
           $photos=$request->file('media_pub');
           $imageExtension=$photos->getClientOriginalExtension();
           $imageName = time();
           $imagOriginal = $imageName.'.'.$imageExtension;
           
           $photos->move('images', $imagOriginal);
       }


    //    //get last pub id
      $id_pub = DB::table('publications')->count();
      


       DB::table('media')->insert([
            "type"=>"photos",
            "chemin"=>$imageName.'.'.$imageExtension,
            "id_pub"=>$id_pub

       ]);
         

        return response()->json([
            "status" => 200,
            "message" => "Publication Ok!",
            "res"=>$id_pub,
        ]);


        }catch(Exception $e){
            return response()->json([
            
                "message" => "Publication Ok!",
               
                "res"=>$e
            ]);
        }

    }

    //afficher les publications
    public function afficherPublication()
    {
        $pubs = DB::table('publications')
                    ->select("publications.id","description","date_pub","pollution","nom_user","categ","chemin"
                    ,DB::raw("count(likes.id) as nbLikes" ),DB::raw("count(commentaires.id) as nbComs"))
                    ->leftJoin("likes","publications.id","likes.id_pub")
                    ->leftJoin("commentaires","publications.id","commentaires.id_pub")
                   ->leftJoin("utilisateurs","utilisateurs.id","publications.id_user")
                    ->leftJoin("media","publications.id","media.id_pub")
                    //->leftJoin("regions","region.id","publications.id_region")
                    ->join("pollutions","pollutions.id","publications.id_pollution")
                    ->leftJoin("htags","htags.id","publications.id_tag")
                    ->groupBy("publications.id","description","date_pub","pollution","categ","nom_user","chemin")
                    ->orderBy("date_pub","desc")
                   // ->orderBy("alertes.id","desc")
                    ->get();
        
    return response()->json([
            "status" =>200,
            "publications"=>$pubs

    ]);       

    }

    //Commenter une publication
    public function commenterPublication(Request $request){
        $com = new Commentaire();
        $com->commentaire = $request->input("commentaire");
        $com->id_pub = $request->input("id_pub");
        $com->id_user = $request->input("id_user");
        $com->date_com = date("Y-m-d");

        $com->save();
        return response()->json([
            "status"  => 200,
            "message" => "Commentaire Ok!"
        ]);
    }

    //Commenter une publication
    public function afficherCommentaire(Request $request){
       $res = "";
       $coms = DB::table('commentaires')->select("commentaire","nom_user","date_com")
                                        ->join("utilisateurs","utilisateurs.id","commentaires.id_user")
                                        ->where("id_pub",$request->get("id_pub"));

        if($coms->count() == 0)
        {
            $res = "aucune commentaire";

        } 
        
        else
         {
            $res = $coms->get();
         }


        
        return response()->json([
            "status" => 200,
            "commentaires" => $res
        ]);
    }
    //liker une publication
    public function likerPublication(Request $request)
    {
         $res = "";
          $like = new Like();
          $like->id_pub = $request->input("id_pub");  
          $like->id_user = $request->input("id_user");
          //tester si l'utilisateur a deja like la pub

          $nbLikeExiste = DB::table("likes")->where("id_user",$request->input("id_user"))->count();
          //si pas encore de like, on ajoute like
          if($nbLikeExiste == 0)
              $like->save();

          //si non, on annule    
          else
            {    
              $id = DB::table('likes')->select("id")
                                      ->where("id_user",$request->input("id_user"))
                                      ->where("id_pub",$request->input("id_pub"));

                $this->annulerLikePublication($id->pluck("id"));
                

            } 
          
           
            
    }
    
    //liker une publication
    public function annulerLikePublication($id)
    {
          DB::table("likes")->where("likes.id",$id)->delete();
        
    }
}


