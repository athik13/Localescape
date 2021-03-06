<?php

namespace App\Http\Controllers;

use App\Accomodations;
use App\accommo_photo;
use App\Helpers\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\Auth;
use Faker\Factory as Faker;
use Image;
use Mohamedathik\PhotoUpload\Upload;
use App\facilities;
//use Twilio\Rest\Client;

class AccomodationsController extends Controller
{
    public function __construct()
    {
        //$this->client = $client;
    }
    
    public function listing($type)
    {
        $accommodations = Accomodations::where('type', $type)->where('active', '1')->paginate(15);
        return view('accommodations.listings', compact('type', 'accommodations'));
    }

    public function detail($type, $slug)
    {
        $faker = Faker::create();
        $facilities = \App\facilities::all();
        $accommodation = Accomodations::where('slug', $slug)->where('active', '1')->first();
        $country = $faker->country;
        return view('accommodations.details', compact('type', 'accommodation', 'facilities', 'country'));
    }

    public function all()
    {
        $accommodations = Accomodations::where('user_id', Auth::guard('extranet')->user()->id)->get();
        return view('extranet.accommodations.newAll', compact('accommodations'));
    }

    public function create()
    {
        $facilities = \App\facilities::all();
        $settings = \App\settings::find('1');
        $categories = explode(',', $settings->categories);
        return view('extranet.accommodations.submit', compact('facilities', 'categories'));
    }

    public function store(Request $request)
    {
        $accommodation = Accomodations::create(Input::except('_token', 'image', 'facilities'));
        $array = $request->facilities;
        if($array) {
            $accommodation->facilities = implode("," ,$array);
        }
        $accommodation->user_id = '0';
        $accommodation->save();

        // Upload image
        $i = 0;
        foreach ($request->image as $photo) {
            $i++;
            $m = ($i == '1') ? '1' : '0';

            $file_name = $accommodation->slug.'-'.time().'-'.$photo->getClientOriginalName();
            $location = $accommodation->type.'/'.$accommodation->slug;

            $url_original = Upload::upload_original($photo, $file_name, $location);
            $url_thumbnail = Upload::upload_thumbnail($photo, $file_name, $location);

            accommo_photo::create([
                'accommo_id' => $accommodation->id,
                'main' => $m,
                'photo_url' => $url_original,
                'thumbnail' => $url_thumbnail,
            ]);
        }
        
        return redirect('extranet/accommodations')->with('alert-success', 'Successfully added new accommodation');
    }

    public function edit($id)
    {
        $acco = Accomodations::find($id);
        
        $facilities = \App\facilities::all();
        $settings = \App\settings::find('1');
        $categories = explode(',', $settings->categories);

        if($acco->user_id == Auth::guard('extranet')->user()->id){
            return view('extranet.accommodations.edit', compact('acco', 'facilities', 'categories'));
        } else {
            return redirect('extranet/accommodations');
        }
    }

    public function update($id, Request $request)
    {
        $acco = Accomodations::find($id);
        $acco->title = $request->title;
        $acco->type = $request->type;
        $acco->description = $request->description;
        $acco->special_offer = $request->special_offer;
        $acco->percents = $request->percents;
        $acco->rating = $request->rating;
        $acco->{'special-offer-text'} = $request->{'special-offer-text'};
        $acco->receive_reviews = $request->receive_reviews;
        $acco->minimum_stay = $request->minimum_stay;
        $acco->address = $request->address;
        $acco->latitude = $request->latitude;
        $acco->longitude = $request->longitude;
        $acco->email = $request->email;
        $acco->phone = $request->phone;
        $acco->{'mobile-phone'} = $request->{'mobile-phone'};
        $acco->facebook = $request->facebook;
        $acco->twitter = $request->twitter;
        $acco->youtube = $request->youtube;
        $acco->website = $request->website;
        $acco->charge_childeren = $request->charge_childeren;
        $acco->pets = $request->pets;
        $acco->cancellation = $request->cancellation;
        $acco->other_policies = $request->other_policies;
        $acco->{'check-in-from'} = $request->{'check-in-from'};
        $acco->{'check-in-to'} = $request->{'check-in-to'};
        $acco->early_check_in = $request->early_check_in;
        $acco->{'check-out-from'} = $request->{'check-out-from'};
        $acco->{'check-out-to'} = $request->{'check-out-to'};
        $acco->late_check_out = $request->late_check_out;
        $array = $request->facilities;
        $acco->facilities = implode("," ,$array);
        $acco->save();

        return redirect('extranet/accommodations')->with('alert-success', 'Successfully edited accommodation');
    }

    public function destroy($id)
    {
        $accommodation = Accomodations::find($id);

        if($accommodation->user_id == Auth::guard('extranet')->user()->id){    
            //Delete Photos
            $photos = $accommodation->photos;
            if(!$photos->isEmpty()){
                foreach ($photos as $photo) {
                    $original = Helper::delete_image_s3($photo->photo_url);
                    $thumbnail = Helper::delete_image_s3($photo->thumbnail);
                    $photo->delete();
                }
            }

            $rooms = $accommodation->rooms;
            //Delete Rooms
            if(!$rooms->isEmpty()){
                foreach ($rooms as $room) {
                    //Delete Room Photos
                    $room_photos = $room->photos;
                    if(!$room_photos->isEmpty()){
                        foreach ($room_photos as $room_photo) {
                            $r_original = Helper::delete_image_s3($room_photo->photo_url);
                            $r_thumbnail = Helper::delete_image_s3($room_photo->thumbnail);
                            $room_photo->delete();
                        }
                    }
                    $room->delete();
                }
            }

            $accommodation->delete();
            return redirect()->back()->with('alert-success', 'Successfully deleted the accommodation');
        } else {
            return redirect('extranet/accommodations');
        }
    }

    public function preview($id)
    {
        $facilities = \App\facilities::all();
        $accommodation = Accomodations::where('id', $id)->first();
        return view('extranet.accommodations.details', compact('accommodation', 'facilities'));
    }

    private function sendMessage($phoneNumber, $message, $from)
    {
        $twilioPhoneNumber = config('services.twilio')['phoneNumber'];
        $messageParams = array(
            'from' => $from,
            'body' => $message
        );

        $this->client->messages->create(
            $phoneNumber,
            $messageParams
        );
    }
}
