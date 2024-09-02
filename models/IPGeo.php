<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * IPGeo is the model behind the contact form.
 */
class IPGeo extends Model
{

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
        ];
    }

        /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
        ];
    }

    public static function geoip()
    {
		$remote_ip = $_SERVER['REMOTE_ADDR'] == '127.0.0.1' ? '31.129.246.170' : $_SERVER['REMOTE_ADDR'];
		$user_agent = $_SERVER['HTTP_USER_AGENT'];
		$api_geo_key = Yii::$app->params['apiGeoKey'];
		$browser = get_browser($user_agent, false);
		//$geo_data = json_decode(file_get_contents("https://api.ipgeolocation.io/ipgeo?ip=$remote_ip&apiKey=$api_geo_key"));
		return [
			'remote_ip' => $remote_ip,
			'device_type' => strtolower($browser->{'device_type'}),
			'platform' => $browser->{'platform'},
			'browser' => $browser->{'browser'},
            /*
			'country_emoji' => $geo_data->{'country_emoji'},
			'country_name' => $geo_data->{'country_name'},
			'currency_name' => $geo_data->{'currency'}->{'name'},
			'zipcode' => $geo_data->{'zipcode'},
			'city' => $geo_data->{'city'},
			'isp' => $geo_data->{'isp'},
            */
		];
	}
}
