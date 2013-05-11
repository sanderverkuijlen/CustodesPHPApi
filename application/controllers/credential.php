<?php
class Credential_Controller extends Base_Controller {

    public function action_query()
    {
        $results        = array();
        $credentials    = Credential::where('user_id', '=', Auth::user()->id)->get();

        foreach($credentials as $credential){

            $results[] = $credential->to_array();
        }

        return json_encode($results);
    }

    public function action_get($id)
    {
        $credential = Credential::where('id' , '=', $id)->where('user_id', '=', Auth::user()->id)->first();

        if($credential != null){
            return json_encode($credential->to_array());
        }
        else{
            Event::fire('404');
        }
    }

    public function action_create()
    {
        $input      = Input::json();

        $credential = new Credential();

        $credential->name           = $input->name;
        $credential->login          = $input->login;
        $credential->password       = $input->password;
        $credential->groupname      = $input->groupname;
        $credential->isfavorite     = (isset($input->isfavorite) && $input->isfavorite == 'true' ? 1 : 0);
        $credential->user_id         = Auth::user()->id;

        $credential->save();
    }

    public function action_update($id)
    {
        $input      = Input::json();

        $credential = Credential::where('id' , '=', $id)->where('user_id', '=', Auth::user()->id)->first();

        if($credential != null){

            $credential->name           = $input->name;
            $credential->login          = $input->login;
            $credential->password       = $input->password;
            $credential->groupname      = $input->groupname;
            $credential->isfavorite     = (isset($input->isfavorite) && $input->isfavorite == 'true' ? 1 : 0);

            $credential->save();
        }
        else{
            Event::fire('404');
        }
    }

    public function action_delete($id)
    {
        $credential = Credential::where('id' , '=', $id)->where('user_id', '=', Auth::user()->id)->first();

        if($credential != null){

            $credential->delete();
        }
        else{
            Event::fire('404');
        }
    }

}