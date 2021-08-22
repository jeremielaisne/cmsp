<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;

class InstallSqlCommand extends Command
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'app:install-sql';
    private $container;
    
    public function __construct(Container $container)
    {
        $this->container = $container;
        
        parent::__construct();
    }

    protected function configure(){ 
        $this
        ->setDescription('Ajoute les infos sql à la base')
        ->setHelp('Cette commande doit être exécutée après la commande d:s:u depuis le repertoire racine')
        ->addArgument('filepath', InputArgument::OPTIONAL, 'File path without sql extension');
    }

    protected function execute(InputInterface $input, OutputInterface $output){
        // Params
        $filepath = $input->getArgument('filepath');
        $defaultScriptFilename = $this->container->getParameter('mysql_file');
        $scriptFolder = $this->container->getParameter('script_folder');
        $scriptPath = $this->container->getParameter('script_path');
        $mysqlFilepath = $this->container->getParameter('mysql_filepath');
        $mysqlCommand = $this->container->getParameter('mysql_command');
        
        // Gestion custom filename
        if ($filepath)
        {
            $filepath = strpos('.sql', $filepath) === false ? $filepath . '.sql' : $filepath;
            $mysqlFilepath = str_replace($defaultScriptFilename, $filepath, $mysqlFilepath);
        }

        $optionsFilepath = $scriptPath . "/mysql_conf.cnf";

        if (!file_exists($optionsFilepath))
        {
            `bash $scriptFolder/createDefaultsFile.sh $scriptPath`; 
        }

        `bash $scriptFolder/updateDatabase.sh $scriptPath $mysqlFilepath $mysqlCommand`; 
        $output->writeln('Ajout des données OK');

        return 1;
    }
}
