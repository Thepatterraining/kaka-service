<?php
namespace App\Data\API\Email;

interface IEmailVerify {


    function RequireEmail($res,$type);

    function CheckEmail($email,$code); 

}
