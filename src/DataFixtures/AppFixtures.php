<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager): void
    {
        $filesToImport = [
            "Attribute" => dirname(__FILE__) . '/../Resources/fixtures/attributes.csv',
            "Security" => dirname(__FILE__) . '/../Resources/fixtures/securities.csv',
            "Fact" => dirname(__FILE__) . '/../Resources/fixtures/facts.csv',
        ];

        foreach ($filesToImport as $className => $file) {
            $csv = fopen($file, 'r');

            $i = 0;
            while (!feof($csv)) {
                $line = fgetcsv($csv);

                if($i > 0 && is_array($line))
                    $this->createEntity($className, $line, $manager);

                $i++;
            }

            $manager->flush();
        }
    }

    /**
     * @param string $className
     * @param array $attributes
     * @param ObjectManager $manager
     */
    private function createEntity(string $className, array $attributes, ObjectManager $manager): void
    {
        $class = sprintf("%s\%s",'App\Entity', $className);
        switch ($className)
        {
            case 'Fact':
                if(count($attributes) === 3) {
                    $entity = new $class($attributes[2]);
                    if($this->hasReference(sprintf('security-%s', $attributes[0]))) {
                        $entity->setSecurity($this->getReference(sprintf('security-%s', $attributes[0])));
                    }

                    if($this->hasReference(sprintf('attribute-%s', $attributes[1]))) {
                        $entity->setAttribute($this->getReference(sprintf('attribute-%s', $attributes[1])));
                    }

                    $manager->persist($entity);
                }
            break;

            default:
                if(count($attributes) === 2) {
                    $entity = new $class((int)$attributes[0], $attributes[1]);
                    $manager->persist($entity);

                    $this->addReference(sprintf("%s-%s", strtolower($className), $attributes[0]), $entity);
                }
            break;
        }


    }

}
