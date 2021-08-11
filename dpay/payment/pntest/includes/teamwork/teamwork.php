<?php

require(dirname(__FILE__) . '/src/Response/Model.php');
require(dirname(__FILE__) . '/src/Response/JSON.php');

require(dirname(__FILE__) . '/src/Response/XML.php');

require(dirname(__FILE__) . '/src/Rest/Model.php');

require(dirname(__FILE__) . '/src/Request/Model.php');
require(dirname(__FILE__) . '/src/Request/JSON.php');

require(dirname(__FILE__) . '/src/Request/XML.php');
require(dirname(__FILE__) . '/src/Project/People.php');
require(dirname(__FILE__) . '/src/People/Status.php');

require(dirname(__FILE__) . '/src/Model.php');
require(dirname(__FILE__) . '/src/Comment/Model.php');
require(dirname(__FILE__) . '/src/Category/Model.php');

require(dirname(__FILE__) . '/src/Message/Reply.php');
require(dirname(__FILE__) . '/src/Me/Status.php');
require(dirname(__FILE__) . '/src/Helper/Str.php');
require(dirname(__FILE__) . '/src/Comment/File.php');
require(dirname(__FILE__) . '/src/Comment/Milestone.php');

require(dirname(__FILE__) . '/src/Comment/Notebook.php');
require(dirname(__FILE__) . '/src/Comment/Task.php');

require(dirname(__FILE__) . '/src/Category/File.php');
require(dirname(__FILE__) . '/src/Category/Link.php');
require(dirname(__FILE__) . '/src/Category/Message.php');

require(dirname(__FILE__) . '/src/Category/Notebook.php');
require(dirname(__FILE__) . '/src/Category/Project.php');


// Stripe singleton
require(dirname(__FILE__) . '/src/Account.php');

require(dirname(__FILE__) . '/src/Factory.php');

require(dirname(__FILE__) . '/src/Auth.php');



// Utilities
require(dirname(__FILE__) . '/src/Activity.php');


// Errors
require(dirname(__FILE__) . '/src/Company.php');
require(dirname(__FILE__) . '/src/Exception.php');

require(dirname(__FILE__) . '/src/File.php');
require(dirname(__FILE__) . '/src/Link.php');
require(dirname(__FILE__) . '/src/Me.php');

// Plumbing
require(dirname(__FILE__) . '/src/Message.php');
require(dirname(__FILE__) . '/src/Milestone.php');

require(dirname(__FILE__) . '/src/Notebook.php');
require(dirname(__FILE__) . '/src/People.php');

// Stripe API Resources
require(dirname(__FILE__) . '/src/Project.php');
require(dirname(__FILE__) . '/src/Rest.php');
require(dirname(__FILE__) . '/src/Task_List.php');
require(dirname(__FILE__) . '/src/Task.php');
require(dirname(__FILE__) . '/src/Time.php');

 /*
$fname="test";
$lname="tet2";
$email="jmanso.or@gmail.com";
$address="b21 row be";
$phone="03239292092";
$phone2="02134651713";
$city="Karachi";
$state="NJ";
$country="PK";
$currency="USD";
$item_description="logo design services";
$company="Junaid mansoor services";
$zip='123123';
*/

if($site==1)
$catid='12554';
else
{
switch ($currency)
{

case "USD":
$catid='12551';
break;

case "AUD":
$catid='12553';
break;

case "GBP":
$catid="12552";
break;
}


}


// START configurtion
const API_KEY = 'forget68crimson';
try {
    // set your keys
    TeamWorkPm\Auth::set(API_KEY);
    // create a Company
    $cnew = TeamWorkPm\Factory::build('company');
    $cnew_id = $cnew->save([
    'name' => "$company",
    'address_one' => "$address",
    'zip' => "$zip",
    'city' => "$city",
    'state' => "$state",
    'countrycode' => "$country",
    'phone' => "$phone2"        
    ]);  
    //echo "company $cnew_id<br>";  
    // create an project
    $project = TeamWorkPm\Factory::build('project');
    $project_id = $project->save([
        'name'=> "$currency $item_description $company",
        'description'=> "$item_description",
        'startDate'=> "",
        'endDate'=> "",
        'companyId'=> "$cnew_id",
        'category_id' => "$catid"
        
    ]);
   // echo "project $project_id<br>";
    // create one people and add to project
    $people = TeamWorkPm\Factory::build('people');
    $person_id = $people->save([
        'first_name'  => "$fname",
        'last_name'   => "$lname",
        'user_name'     => "$email",
        'email_address' => "$email",
        'password'      => "$fname@$lname",
        'project_id'    => $project_id,
        'phone_number_mobile' => "$phone",
        'phone_number_office' => "$phone2",
        'company_id' => $cnew_id,
        'sendWelcomeEmail'=> "no"
    ]);
   // echo " people $person_id<br>";
    // create milestone
    
    /*
    $milestone = TeamWorkPm\Factory::build('milestone');
    $milestone_id = $milestone->save([
        'project_id'            => $project_id,
        'responsible_party_ids' => $person_id,
        'title'                 => 'Test milestone',
        'description'           => 'Bla, Bla, Bla',
        'deadline'              => date('Ymd', strtotime('+10 day'))
    ]);
    // create one task list
    $taskList = TeamWorkPm\Factory::build('task.list');
    $task_list_id = $taskList->save([
        'project_id'  => $project_id,
        'milestone_id' => $milestone_id,
        'name'        => 'My first task list',
        'description' => 'Bla, Bla'
    ]);
    // create one task
    $task = TeamWorkPm\Factory::build('task');
    $task_id = $task->save([
        'task_list_id' => $task_list_id,
        'content'      => 'Test Task',
        'notify'       => false,
        'description'  => 'Bla, Bla, Bla',
        'due_date'     => date('Ymd', strtotime('+10 days')),
        'start_date'   => date('Ymd'),
        'private'      => false,
        'priority'     => 'high',
        'estimated_minutes' => 1000,
        'responsible_party_id' => $person_id,
    ]);
    // add time to task
    $time = TeamWorkPm\Factory::build('time');
    $time_id = $time->save([
        'task_id'     => $task_id,
        'person_id'   => $person_id, // this is a required field
        'description' => 'Test Time',
        'date'  => date('Ymd'),
        'hours'     => 5,
        'minutes' => 30,
        'time' => '08:30',
        'isbillable' => false
    ]);
    echo 'Project Id: ', $project_id, "\n";
    echo 'Person Id: ', $person_id, "\n";
    echo 'Milestone Id: ', $milestone_id, "\n";
    echo 'Task List Id: ', $task_list_id, "\n";
    echo 'Task Id: ', $task_id, "\n";
    echo 'Time id: ', $time_id, "\n";
    */
    
    $teamworkurl="https://designservices.teamwork.com/projects/$project_id/overview";
} 
catch (Exception $e) {
   // print_r($e);
}
?>