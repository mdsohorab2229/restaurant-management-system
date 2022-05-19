<?php
/**
 * Created by PhpStorm.
 * User: jnahian
 * Date: 10/4/18
 * Time: 2:24 AM
 */
/**
 * Gender dropdown data
 */
if (!function_exists('getGendersList')) {
    function getGendersList()
    {

        $gender = [
            '' => 'Select',
            'Male' => 'Male',
            'Female' => 'Female',
        ];

        return $gender;
    }
}

/**
 * Department dropdown data
 */
if (!function_exists('getDepartmentsList')) {
    function getDepartmentsList()
    {

        $departments = [
            '' => 'Select',
            1 => 'Department 1',
            2 => 'Department 2'
        ];

        return $departments;
    }
}

/**
 * Status
 */
if (!function_exists('getStatus')) {
    function getStatus($status = null)
    {
        $statuses = [
            1 => "Active",
            0 => "Inactive"
        ];


        return $status || $status === 0 ? $statuses[$status] : $statuses;
    }
}

/**
 * Exam Terms
 * 
 */
if (!function_exists('getTerms')) {
    function getTerms($term = null)
    {
        $terms = [
            1 => "Mid Term",
            2 => "Final"
        ];


        return $term || $term === 0 ? $terms[$term] : $terms;
    }
}

/**
 * @mf  make a dropDown by laravel collection
 * @return as key => value data
 */
if (!function_exists('makeDropDown')) {
    function makeDropDown($objects, $key = 'id', $value = 'name')
    {
        $data = [
            '' => 'Select'
        ];

        foreach ($objects as $object) {
            $data = array_add($data, $object->$key, $object->$value);

        }

        return $data;
    }
}


if (!function_exists('getBankType')) {
    function getBankType()
    {

        $types = [
            '' => 'Select',
            'deposite' => 'Deposite',
            'withdraw' => 'Withdraw',
        ];

        return $types;
    }

}


/*
*@belalkhan
*
*/
if (!function_exists('getGuardianType')) {
    function getGuardianType()
    {
        $guardian_type = [
            '' => 'Select',
            '1' => 'New Guardian',
            '2' => 'Existing Guardian',
        ];

        return $guardian_type;
    }
}


/**
 * @mf  Institution Type
 * @return institution type list
 */
if (!function_exists('institutionTypes')) {
    function institutionTypes()
    {
        $types = [
            '' => 'Select',
            'School' => 'School',
            'College' => 'College',
            'University' => 'University',
        ];

        return $types;
    }
}

/**
 * for database datetime
 */
if (!function_exists('database_formatted_datetime')) {
    function database_formatted_datetime($date = null)
    {
        return $date ? date('Y-m-d H:i:s', strtotime($date)) : date('Y-m-d H:i:s');
    }
}

/**
 * for database date
 */
if (!function_exists('database_formatted_date')) {
    function database_formatted_date($date = null)
    {
        return $date ? date('Y-m-d', strtotime($date)) : date('Y-m-d');
    }
}

/**
 * for database time
 */
if (!function_exists('database_formatted_time')) {
    function database_formatted_time($date = null)
    {
        return $date ? date('H:i:s', strtotime($date)) : date('H:i:s');
    }
}

/**
 * for user date
 */
if (!function_exists('user_formatted_date')) {
    function user_formatted_date($date = null)
    {
        return $date ? date('d M, y', strtotime($date)) : date('d M, y');
    }
}

/**
 * for user datetime
 */
if (!function_exists('user_formatted_datetime')) {
    function user_formatted_datetime($date = null)
    {
        return $date ? date('d M, y  h:i A', strtotime($date)) : date('d M, y  h:i A');
    }
}

/**
 * for user time
 */
if (!function_exists('user_formatted_time')) {
    function user_formatted_time($date = null)
    {
        return $date ? date('h:i A', strtotime($date)) : date('h:i A');
    }
}

/**
 * @belal
 * for notice user type (all or individual)
 */
if (!function_exists('getNoticeUserType')) {
    function getNoticeUserType()
    {
        $noticeType = [
            '' => 'Select',
            '0' => 'All',
            '1' => 'Individual'
        ];

        return $noticeType;
    }
}

/**
 * @mf Fees type
 */
if (!function_exists('feesTypes')) {
    function feesTypes()
    {
        $types = [
            '' => 'Select',
            'Monthly' => 'Monthly',
            'Yearly' => 'Yearly',
        ];

        return $types;
    }
}


/**
 * Routine Types for dropdown menu
 */
if (!function_exists('routineTypeList')) {
    function routineTypeList($type = null)
    {
        $data = [
            'C' => 'Class',
            'E' => 'Exam',
        ];

        if ($type && array_key_exists($type, $data)) {
            return $data[$type];
        } else {
            return $data;
        }
    }
}

/**
 * Session for dropdown menu
 */
if (!function_exists('sessionList')) {
    function sessionList()
    {
        $current_year = 2015;
        $previous_year = $current_year - 1;
        $session = [];
        $session["$previous_year-$current_year"] = "$previous_year-$current_year";

        $loop_end_year = date('Y', strtotime("+5 years"));

        $loop_count = $loop_end_year - $current_year;

        for ($i = 1; $i <= $loop_count; $i++) {
            $current_year++;
            $previous_year++;
            $session["$previous_year-$current_year"] = "$previous_year-$current_year";
        }

        return $session;
    }
}

if (!function_exists('checkExamEditable')) {
    function checkExamEditable($exam)
    {
        $date = database_formatted_datetime("$exam->date $exam->start_time");

        $now = database_formatted_datetime();

        if($date > $now){
            return true;
        }

        return false;
    }
}


/**
 * Payment method
 * by bk
 */
if (!function_exists('getPaymentMethod')) {
    function getPaymentMethod($method = null)
    {
        $methods = [
            'cash' => 'Cash',
            'check' => 'Check',
            'card' => 'Card',
            'bkash' => 'Bkash',
            'rocket' => 'Rocket',
        ];


        return $method || $method === 0 ? $methods[$method] : $methods;
    }
}
/**
 * Payment status
 * by Belal
 */
if (!function_exists('getPaymentStatus')) {
    function getPaymentStatus($status = null)
    {
        $statuses = [
            1 => "Paid",
            0 => "Unpaid"
        ];


        return $status || $status === 0 ? $statuses[$status] : $statuses;
    }
}

/**
 * Check yes or no
 * by Belal
 */
if (!function_exists('getCheckStatus')) {
    function getCheckStatus($check = null)
    {
        $checks = [
            '' => 'Select',
            'yes' => "Yes",
            'no' => "No"
        ];


        return $check || $check === 0 ? $checks[$status] : $checks;
    }
}

/**
 * days status
 * by Belal
 */
if (!function_exists('getDaysList')) {
    function getDaysList($day = null)
    {
        $days = [
            'Saturday' =>  'Saturday',
            'Sunday' =>  'Sunday',
            'Monday' =>  'Monday',
            'Tuesday' =>  'Tuesday',
            'Wednesday' =>  'Wednesday',
            'Thursday' =>  'Thursday',
            'Friday' =>  'Friday',
        ];


        return $day || $day === 0 ? $days[$day] : $days;
    }

}

/**
 * discount status
 * by Tanbeer
 */
if (!function_exists('getDiscountStatus')) {
    function getDiscountStatus($status = null)
    {
        $statuses = [
            0 => "Amount",
            1 => "Percentage(%)"
        ];


        return $status || $status === 0 ? $statuses[$status] : $statuses;
    }
}

/**
 * tax status
 * by Tanbeer
 */
if (!function_exists('getTaxStatus')) {
    function getTaxStatus($status = null)
    {
        $statuses = [
            0 => "Inclusive",
            1 => "Exclusive"
        ];


        return $status || $status === 0 ? $statuses[$status] : $statuses;
    }
}

/**
 * available status
 * by Tanbeer
 */
if (!function_exists('getAvailableStatus')) {
    function getAvailableStatus($status = null)
    {
        $statuses = [

            1 => "Available",
            0 => "Not Availble",
        ];


        return $status || $status === 0 ? $statuses[$status] : $statuses;
    }
}

/**
 * Occupation for guest details
 * by Tanbeer
 */
if (!function_exists('getOccupationStatus')) {
    function getOccupationStatus($status = null)
    {
        $statuses = [

            0 => "Student",
            1 => "Govt Service",
            2 => "Private Service",
            3 => "Busness",
            4 => "Others",
        ];


        return $status || $status === 0 ? $statuses[$status] : $statuses;
    }
}
/**
 * available status for room
 * by Tanbeer
 */
if (!function_exists('getAvailableRoomStatus')) {
    function getAvailableRoomStatus($status = null)
    {
        $statuses = [

            0 => "Not Availble",
            1 => "Available",
            2 => "Booked",
        ];


        return $status || $status === 0 ? $statuses[$status] : $statuses;
    }
}
/**
 * hide
 * by Belal
 */
if (!function_exists('getHideVal')) {
    function getHideVal($status = null)
    {
        return 50;
    }
}

/**
 * @thbappy  make a dropDown by laravel collection
 * @return as key => value data
 */
if (!function_exists('getLoanTerm')) {
    function getLoanTerm()
    {

        $types = [
            '' => 'Select',
            'long' => 'long',
            'short' => 'short',
        ];

        return $types;
    }

}

if (!function_exists('getLoanTerm')) {
    function getLoanTerm()
    {

        $types = [
            '' => 'Select',
            'long' => 'long',
            'short' => 'short',
        ];

        return $types;
    }

}

if (!function_exists('getLoanDuration')) {
    function getLoanDuration()
    {

        $durationtypes = [
            '' => 'Select',
            'one' => 'one',
            'two' => 'two',
            'three' => 'three',
            'four' => 'four',
            'five' => 'five',
            'six' => 'six',
            'seven' => 'seven',
            'eight' => 'eight',
            'nine' => 'nine',
            'ten' => 'ten',
        ];

        return $durationtypes;
    }

}
if (!function_exists('getLoanType')) {
    function getLoanType()
    {

        $types = [
            '' => 'Select',
            'loan_deposite' => 'Loan_Deposite',
            'loan_withdraw' => ' Loan_Withdraw',
        ];

        return $types;
    }

}

