package com.rzkwsnj.stugate.helpers;

import com.rzkwsnj.stugate.config.Config;
import com.rzkwsnj.stugate.models.AuthLogin;
import com.rzkwsnj.stugate.models.Data;

import retrofit2.Call;
import retrofit2.http.Field;
import retrofit2.http.FormUrlEncoded;
import retrofit2.http.GET;
import retrofit2.http.POST;
import retrofit2.http.Query;

/**
 * This file may not be redistributed in whole or significant part.
 * ---------------- THIS IS NOT FREE SOFTWARE ----------------
 *
 *
 * @file        ApiInterface.java
 * @package     Student Payment Validation System
 * @author      rzkwsnj <drg.rizkiwisnuaji@gmail.com>
 * @copyright   2022 rzkwsnj. All Rights Reserved.
 * @license     https://opensource.org/licenses/MIT
 * @version     Release: @1.0.0@
 * @framework   http://php.net
 *
 *
 * ---------------- THIS IS NOT FREE SOFTWARE ----------------
 * This file may not be redistributed in whole or significant part.
 **/

public interface ApiInterface {

    @FormUrlEncoded
    @POST("login.php")
    Call<AuthLogin> login(
            @Field(Config.POST_EMAIL) String email,
            @Field(Config.POST_PASSWORD) String password);

    //get data
    @GET("get_data.php")
    Call<Data> getdata(
            @Query(Config.POST_CODE) String searccodehText);
}
