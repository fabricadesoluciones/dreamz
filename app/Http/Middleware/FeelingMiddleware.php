<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Session;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\DailyEmotion;
use App;
use Response;
use DB;

class FeelingMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(Auth::check()){

            if( ! session('language')){
                Session::set('language', 'en');
            }
                App::setLocale( session('language') );
            if ( ! session('feeling') ) {
                $whereClause = ['emotion_date' => date('Y-m-d'), 'user' => Auth::user()->user_id];

                $todays_emotion = DB::table('daily_emotions')
                ->where($whereClause)
                ->first();

                if ( $todays_emotion) {
                    Session::set('feeling', json_encode($todays_emotion));
                }else{
                    if ($request->segments()[0] != 'home' && $request->segments()[0] != 'set_feeling' && $request->segments()[0] != 'logout' &&  ! Auth::user()->can("list-companies") ){
                        $errorResponse = ['code'=>403,'title' =>  'No tan pronto', 'message' => 'Antes registra como te sientes hoy '. date('Y-m-d') ,'data' => []];
                        Session::flash('update', $errorResponse);
                        return redirect(route('home'));
                    }
                }
            }

        }
            return $next($request);

    }
}
