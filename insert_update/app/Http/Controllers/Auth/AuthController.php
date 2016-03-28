<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Input;
use File;
use DB;
use Request;

class AuthController extends Controller {
    /*
      |--------------------------------------------------------------------------
      | Registration & Login Controller
      |--------------------------------------------------------------------------
      |
      | This controller handles the registration of new users, as well as the
      | authentication of existing users. By default, this controller uses
      | a simple trait to add these behaviors. Why don't you explore it?
      |
     */

use AuthenticatesAndRegistersUsers,
    ThrottlesLogins;

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('guest', ['except' => 'getLogout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data) {
        return Validator::make($data, [
                    'code_enregistrement' => 'max:2',
                    'client_id' => 'max:20',
                    'code_mouvement' => 'max:1',
                    'civility' => 'max:4',
                    'last_name' => 'max:50',
                    'first_name' => 'max:50',
                    'birthday' => 'date',
                    'zip_code' => 'max:5',
                    'email' => 'email|max:254',
                    'address_line1' => 'max:255',
                    'address_line2' => 'max:255',
                    'address_line3' => 'max:255',
                    'address_line4' => 'max:255',
                    'address_line5' => 'max:255',
                    'address_line6' => 'max:255',
                    'visu_id' => 'max:5',
                    'card_number' => 'max:4'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data) {
        return User::create([
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'password' => bcrypt($data['password']),
        ]);
    }

    public function upload() {
        return view('uploadfile');
    }

    public function runProcess() {
        if(Request::ajax()) {
            $data = Input::all();
            print_r($data);
            die;
        }
//        return sleep(2);
    }

    public function insertUser($data) {
        $format_birthday_csv1 = substr_replace($data[6], '-', 2, 0);
        $format_birthday_csv2 = substr_replace($format_birthday_csv1, '-', 5, 0);
        $format_birthday_csv = \DateTime::createFromFormat('d-m-Y', $format_birthday_csv2);
        $birthday_csv = date_format($format_birthday_csv, "Y-m-d");
        $query = DB::select('select * from stream_bank_users where last_name = ? and first_name = ? and birthday = ?', [$data[4], $data[5], $birthday_csv]
        );
        
        if ($query != FALSE) {
            // update user
            DB::table('stream_bank_users')
                    ->where([
                        'last_name' => $data[4],
                        'first_name' => $data[5],
                        'birthday' => $birthday_csv,
                    ])
                    ->update([
                        'code_enregistrement' => $data[0],
                        'client_id' => $data[1],
                        'code_mouvement' => $data[2],
                        'civility' => $data[3],
                        'zip_code' => $data[7],
                        'email' => $data[8],
                        'address_line1' => $data[9],
                        'address_line2' => $data[10],
                        'address_line3' => $data[11],
                        'address_line4' => $data[12],
                        'address_line5' => $data[13],
                        'address_line6' => $data[14],
                        'visu_id' => $data[15],
                        'card_number' => $data[16],
            ]);
        } else {
            //insert user
            DB::insert('insert into stream_bank_users(code_enregistrement, client_id, code_mouvement, civility, last_name, first_name, birthday, zip_code, email, address_line1, address_line2, address_line3, address_line4, address_line5, address_line6, visu_id, card_number) '
                    . 'values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)'
                    , array($data[0], $data[1], $data[2], $data[3], $data[4], $data[5], $data[6], $data[7], $data[8], $data[9], $data[10], $data[11], $data[12], $data[13], $data[14], $data[15], $data[16]));
        }
        return $query;
    }

    public function process() {
        $handle = fopen('daily_imports_csv.csv', "r");
        $_SESSION['items_csv'] = array();
        while (($fileop = fgetcsv($handle, 1000, "\n")) !== false) {
            if (!is_null($fileop[0])) {
                $_SESSION['items_csv'][] = $fileop[0];
            }
        }
        unset($_SESSION['items_csv'][0]);
        for ($i = 4; $i <= count($_SESSION['items_csv']); $i++) {
            $data = explode(',', $_SESSION['items_csv'][$i]);
            if ($this->validator($data)->fails() == FALSE) {

                // call insert function
                $this->insertUser($data);
//                return redirect('/run');
            }
        }
        
        return view('uploadfile')->with(array(
//            'total' => count($_SESSION),
        ));

//        return view('welcome');
    }

}
