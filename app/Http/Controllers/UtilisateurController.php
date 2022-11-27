<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\utilisateurs;
use Illuminate\Support\Facades\DB;

class UtilisateurController extends Controller
{
    public function store(Request $request)
    {
        try{

      
        $imagOriginal="";
        if(!is_null($request->file('photo_user')))
        {
            $photos=$request->file('photo_user');
            $imageExtension=$photos->getClientOriginalExtension();
            $imagOriginal = time().'.'.$imageExtension;
            
            $photos->move('images', $imagOriginal);
        }

        if($request->file('mdp_user') == $request->file('mdp_user_confirm'))
        {
            $utilisateurs = new utilisateurs;
            $utilisateurs->nom_user=$request->input("nom_user");
            $utilisateurs->email_user=$request->input("email_user");
            $utilisateurs->mdp_user=$request->input("mdp_user");
            $utilisateurs->photo_user=$imagOriginal;
            $utilisateurs->role_user='a';
            $utilisateurs->save();
            $variable = "Utilisateur ajouter";
        }else
        {
            $variable = "Verifier vos champs";
        }
        

        return response()->json([
            'status'=>200,
            'message'=> $variable,
        ]);
        }catch(Exception $e){
            return response()->json([
            'status'=>200,
            'message'=> $e,
        ]);
        }
    }

    public function loginUser(Request $request){
        $mail = $request->input('email_user_con');
        $mdp = $request->input('mdp_user_con');

        // ****************************************************************************/
        $user = DB::table('utilisateurs')
                    ->select('*')
                    ->where('email_user','=',$mail)
                    ->get();
        
        if(sizeof($user)<=0){
            return response([
                'erreur' => 'Compte inexistant',
                'message' => 'Veuillez vérifier votre adresse mail',
                'user' => $mail,
                'authentification' => 'false',
            ]);
        } else {
            $existing_user = DB::table('utilisateurs')
                    ->select('*')
                    ->where('email_user','=',$mail)
                    ->where('mdp_user','=',$mdp)
                    ->get();
            if(sizeof($existing_user)<=0){
                return response([
                    'erreur' => 'Mot de passe incorrect',
                    'message' => 'Veuillez vérifier votre mot de passe',
                    'authentification' => 'false',

                ]);
            } else {
                
                return response([
                    'data' => $existing_user,
                    'message' => 'ok',
                    'authentification' => 'true',
                    'email'=> $mail,
                ]);
                
            }
        }

        /*************************************************************************** */

        return json_encode($mail);
    }
}
