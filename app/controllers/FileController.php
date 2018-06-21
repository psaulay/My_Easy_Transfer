<?php

namespace Controllers;

use Core\Controllers\Controller;
use Model\File;

class FileController extends Controller {

    /**
     * Index method
     *
     * @param string $page
     * @return void
     */
    public function index($page = "1")
    {
        $files = File::find();

        echo $this->twig->render('files/index.html.twig', [
            'files' => $files
        ]);
    }

    public function download($idFile) 
    {
        // requete pour recuperer l'objet file
        $file = File::findOne([
            'random_id' => $idFile,
        ]);
        $filebis = (array) $file;
        //var_dump($category); die();

        echo $this->twig->render('files/download_page.html.twig', [
            'file' => $filebis["file_name"],
            'message' => $filebis["creator_message"],
            'idFile' => $idFile,
        ]);
    }

    public function success($idFile) 
    {
        // requete pour recuperer l'objet file
        $file = File::findOne([
            'random_id' => $idFile,
        ]);
        $filebis = (array) $file;
        //var_dump($category); die();

        echo $this->twig->render('files/success.html.twig', [
            'file' => $filebis["file_name"],
            'idFile' => $idFile,
        ]);
    }


        
    /**
     * Deleting file
     *
     * @param int $id
     * @return void
     */
    public function delete($id) 
    {
        $file = File::findOne([
            'random_id' => $id
        ]);
        $file_name_bis = (array)$file;
        $file_name = $file_name_bis["file_name"];
        //var_dump($file_name); die();
        //$file->delete();
        unlink('upload/'.$file_name.'');
        $this->flashbag->set('alert', [
            'type' => 'success',
            'msg' => 'File deleted !'
        ]);

        $this->url->redirect('file');
    }

    /**
     * Add category
     *
     * @return void
     */
    public function add()
    {
        $dossier = 'upload/';
        $fichier = basename($_FILES['uploaded_file']['name']);
        //var_dump($_FILES); die();
        if(move_uploaded_file($_FILES['uploaded_file']['tmp_name'], $dossier . $fichier)) {
            echo 'Upload effectué avec succès !';
        } else {
            echo 'Echec de l\'upload !';
        }

        if (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $ip=$_SERVER['HTTP_CLIENT_IP'];
        } elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip=(isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '');
        }

        $file = new File();

        $file->creator_ip = $ip;
        $file->creator_email = $_POST['creator_email'];
        $file->recipient_email = $_POST['recipient_email'];
        $file->creator_message = $_POST['creator_message'];
        $file->file_name = $_FILES["uploaded_file"]["name"];
        $random_id = rand(1, 1000000);
        $file->random_id = $random_id ;
        $file->save();
        $headers = "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
        $headers .= "From: $mail";
        $download_page_url = "<a href='".$_SERVER['SERVER_NAME']."/my_easy_transfer/files/download_page/".$random_id."'>cliquez ici</a>";
        $recipient_email = $_POST['recipient_email'];
        $creator_email = $_POST['creator_email'];
        $objet = $creator_email." vous as envoyé un fichier";
        $msg = "Le fichier est disponible à cette adresse ".$download_page_url ;

        if ( preg_match ( " /^.+@.+\.[a-zA-Z]{2,}$/ " , $recipient_email ) ){
            mail($recipient_email, $objet, $msg,  $headers);
        }else{
            $this->flashbag->set('alert', [
                'type' => 'success',
                'msg' => "Recipient's mail is not valid, please enter a new one. ",
            ]);
        }

        if ( preg_match ( " /^.+@.+\.[a-zA-Z]{2,}$/ " , $creator_email ) ){
            mail($creator_email, $objet, $msg, $headers);
        }else{
            $this->flashbag->set('alert', [
                'type' => 'success',
                'msg' => "Your mail is not valid, please enter a new one. ",
            ]);
        }
        $this->flashbag->set('alert', [
            'type' => 'success',
            'msg' => 'file uploaded ! you will receive a link to the download page ',
        ]);
        

        $this->url->redirect('success/'.$file->random_id);
    }
}