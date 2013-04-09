<?php
class block_progressbar extends block_base {
    function init() 
    {
        $this->title = get_string('pluginname', 'block_progressbar');
    }
    
    function get_content() {
    global $DB;
    global $USER;
    if ($USER->id == 0)
        return 0;
    //Verify if the user is enrolled in any courses
	$nr_enrolled_courses = $DB->count_records('role_assignments', array ( 'roleid' => '5', 'userid' => "$USER->id"));
	if ($nr_enrolled_courses > 0)
	{
    
        //Find contexts where USER is a student
		$courses_context = $DB->get_fieldset_select('role_assignments', 'contextid', "roleid = 5 and userid = $USER->id", null);
		foreach ($courses_context as $course)
		{
    
            //Find matching course ID for context
            $course_no = $DB->get_field_select('context', 'instanceid', "id = $course", null);
            $course_id = $course_no;
            $course_name = $DB->get_field_select('course', 'shortname', "id = $course_id", null);
            
            //Find assignments for each course
            $crr_time = time();
			$due_dates = $DB->get_fieldset_select('assign', 'duedate', "course = $course_no AND duedate > $crr_time", null);
			$allow_subs = $DB->get_fieldset_select('assign', 'allowsubmissionsfromdate', "course = $course_no AND duedate > $crr_time", null);
            $hw_name = $DB->get_fieldset_select('assign', 'name', "course = $course_no AND duedate > $crr_time",null);
            
            //Create a progressbar for each assignment (if there is more than one
            //in each course)
            if (is_array($due_dates))
            {
                for ($i=0; $i < count($due_dates); $i++) 
                {
                    $av_time = intval (($due_dates[$i] - $allow_subs[$i]) / 100);
                    $passed_time = time() - $allow_subs[$i];
                    $assgn_prog = intval($passed_time / $av_time);
                    if($assgn_prog < 1)
                        $assgn_prog = 1;
                 if ($assgn_prog <= 50)
                    $this->content->text .= "$course_name - $hw_name[$i] - $assgn_prog% <div class=\"progress progress-striped active\"> <div class=\"bar bar-success\" style=\"width: $assgn_prog%;\"></div></div>";
                 else
				    if ($assgn_prog <= 80)
                      $this->content->text .= "$course_name - $hw_name[$i] - $assgn_prog%<div class=\"progress progress-striped active\"> <div class=\"bar bar-warning\" style=\"width: $assgn_prog%;\"></div></div>";
                    else
                      $this->content->text .= "$course_name - $hw_name[$i] - $assgn_prog%<div class=\"progress progress-striped active\"> <div class=\"bar bar-danger\" style=\"width: $assgn_prog%;\"></div></div>";
                }
            }
            else

                //Create a progressbar if there is only one assignment in 
                //current course
                if ($due_dates)
                {
                    $av_time = intval (( $due_dates - $allow_subs ) / 100 );
                    $passed_time = time() - $allow_subs;
                    $assgn_prog = intval( $passed_time / $av_time );
                    if ($assgn_prog < 1)
                        $assgn_prog = 1;
                    echo $assgn_prog;
                    if($assgn_prog <= 50)
                         $this->content->text .= "$course_name - $hw_name[$i] - $assgn_prog%<div class=\"progress progress-striped active\"> <div class=\"bar bar-success\" style=\"width: $assgn_prog%;\"></div>$hw_name</div>";
                    else
                        if ($assgn_prog <= 80)
                            $this->content->text .= "$course_name - $hw_name[$i] - $assgn_prog%<div class=\"progress progress-striped active\"> <div class=\"bar bar-warning\" style=\"width: $assgn_prog%;\"></div>$hw_name</div>";
                        else
                            $this->content->text .= "$course_name - $hw_name[$i] - $assgn_prog%<div class=\"progress progress-striped active\"> <div class=\"bar bar-danger\" style=\"width: $assgn_prog%;\"></div>$hw_name</div>";
                }
        }
        if (empty($this->content->text))
        {
            //In case the user has no pending assignments
            $this->content->text = get_string('noassgn', 'block_progressbar');
        }    
    }
	else
    {
        //In case the user is not enrolled in any courses
		$this->content->text .= get_string('nocourse', 'block_progressbar');
	}

	return $this->content;
    }
    function has_config() {return true;}
}
