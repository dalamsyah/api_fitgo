<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Log;
use App\Team;

class TeamController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function save(Request $request){
        $data = [
            "nama_team" => $request->input("nama_team"),
            "image_url" => $request->input("image_url"),
            "email" => $request->input("email")
        ];

        // Log::debug($request); exit;

        $file = $request->file('image');
        $file->move("images", $request->input("nama_team")."_".$file->getClientOriginalName());

        $save = Team::create($data);
        $team = Team::where("id", $save->id)->first();

        if ($save) {
            $out = [
                "code" => 201,
                "message" => "create team succesfuly!",
                "results"  => [
                    "team" => $team
                ]
            ];

            return response()->json($out, $out["code"]);

        }

        $out = [
            "code" => 200,
            "message" => "failed create team!",
            "results"  => $data
        ];

        return response()->json($out, $out["code"]);

    }

    public function delete($id){
        $row = DB::table('teams')
              ->where('id', $id )
              ->update(['deleted' => 'true']);

        if($row == 0){
            $out = [
            "code" => 200,
                "message" => "tidak ada data yang di hapus!",
                "results"  => [
                    "deleted" => $row
                ]
            ];

            return response()->json($out, $out["code"]);
        }

        $out = [
            "code" => 201,
            "message" => "success deleted team!",
            "results"  => [
                "deleted" => $row
            ]
        ];

        return response()->json($out, $out["code"]);
    }

    //
}
