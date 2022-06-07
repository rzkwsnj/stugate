package com.rzkwsnj.stugate.models;

import com.google.gson.annotations.SerializedName;

/**
 * This file may not be redistributed in whole or significant part.
 * ---------------- THIS IS NOT FREE SOFTWARE ----------------
 *
 *
 * @file        Data.java
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

public class Data {

    @SerializedName("student_name")
    private String studentName;

    @SerializedName("student_code")
    private String studentCode;

    @SerializedName("student_department")
    private String studentDepartment;

    @SerializedName("student_level")
    private String studentLevel;

    @SerializedName("student_status")
    private String studentStatus;

    @SerializedName("student_session_paid")
    private String studentSessionPaid;

    @SerializedName("student_image")
    private String studentImage;

    @SerializedName("value")
    private String value;

    @SerializedName("message")
    private String message;

    public String getStudentName() {
        return studentName;
    }

    public String getStudentCode() {
        return studentCode;
    }

    public String getStudentDepartment() {
        return studentDepartment;
    }

    public String getStudentLevel() {
        return studentLevel;
    }

    public String getStudentStatus() {
        return studentStatus;
    }

    public String getStudentSessionPaid() {
        return studentSessionPaid;
    }

    public String getStudentImage() {
        return studentImage;
    }

    public String getValue() {
        return value;
    }

    public String getMessage() {
        return message;
    }
}
