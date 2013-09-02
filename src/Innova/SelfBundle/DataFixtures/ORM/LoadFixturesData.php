<?php

namespace Innova\SelfBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Innova\SelfBundle\Entity\Test;
use Innova\SelfBundle\Entity\Questionnaire;

class LoadUserData implements FixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $test = new Test();
        $test->setNom('Test de base');
        $manager->persist($test);

        $questionnaire1 = new Questionnaire();
        $questionnaire1->addTest($test);
        $questionnaire1->setConsigne('consigne questionnaire1 1');
        $questionnaire1->setLevel("A2");
        $questionnaire1->setSource("Conçu en interne");
        $questionnaire1->setSupportType("enregistrement local (MLC)");
        $questionnaire1->setTypology("QRU");
        $questionnaire1->setFocus("communicatif/sociolinguistique");
        $questionnaire1->setCognitiveOperation("- saisir le sens global du message - reconnaître les registres de langues et les variétés textuelles - interagir ");
        $questionnaire1->setFunction("sensible");
        $questionnaire1->setReceptionType("en tant qu’interactant  (entre 2 ou plusieurs personnes)");
        $questionnaire1->setDomain("public");
        $questionnaire1->setGenre("* Bi/pluridirectionnel :  - Courts échanges sociaux dans des lieux publics  (p. e .: restaurants, hôtels, maisons de tourisme, banques, magasins, bureaux de poste etc.)");
        $questionnaire1->setSourceType("construit");
        $questionnaire1->setLanguageLevel("mixte");
        $questionnaire1->setDurationGroup("écoute brève : 5’’- 20’’");
        $questionnaire1->setFlow("moyen");
        $questionnaire1->setWordCount("");
        $questionnaire1->setTheme("A la boulangerie ");
        $questionnaire1->setAuthor("");
        $questionnaire1->setConsigne("");
        $questionnaire1->setAudioConsigne("");
        $questionnaire1->setAudioContexte("");
        $questionnaire1->setAudioItem("");

        $manager->persist($questionnaire1);

        $questionnaire2 = new Questionnaire();
        $questionnaire2->addTest($test);
        $questionnaire2->setConsigne('consigne questionnaire2 1');
        $questionnaire2->setLevel("A2");
        $questionnaire2->setSource("Conçu en interne");
        $questionnaire2->setSupportType("enregistrement local (MLC)");
        $questionnaire2->setTypology("QRU");
        $questionnaire2->setFocus("communicatif/sociolinguistique");
        $questionnaire2->setCognitiveOperation("reconnaître le contexte (où se déroule l’action, à travers quoi...)");
        $questionnaire2->setFunction("sensible");
        $questionnaire2->setReceptionType("en tant qu’auditeur: - bi/pluri-directionnel (échanges de communication)");
        $questionnaire2->setDomain("public");
        $questionnaire2->setGenre("* Bi/pluridirectionnel :  - Courts échanges sociaux dans des lieux publics  (p. e .: restaurants, hôtels, maisons de tourisme, banques, magasins, bureaux de poste etc.)");
        $questionnaire2->setSourceType("construit");
        $questionnaire2->setLanguageLevel("standard");
        $questionnaire2->setDurationGroup("écoute brève : 5’’- 20’’");
        $questionnaire2->setFlow("moyen");
        $questionnaire2->setWordCount("");
        $questionnaire2->setTheme("Achat d’un CD");
        $questionnaire2->setAuthor("");
        $questionnaire2->setConsigne("");
        $questionnaire2->setAudioConsigne("");
        $questionnaire2->setAudioContexte("");
        $questionnaire2->setAudioItem("");

        $manager->persist($questionnaire2);

        $questionnaire3 = new Questionnaire();
        $questionnaire3->addTest($test);
        $questionnaire3->setConsigne('consigne questionnaire3');
        $questionnaire3->setLevel("A2");
        $questionnaire3->setSource("Conçu en interne");
        $questionnaire3->setSupportType("enregistrement local (MLC)");
        $questionnaire3->setTypology("QRU");
        $questionnaire3->setFocus("communicatif/sociolinguistique");
        $questionnaire3->setCognitiveOperation("reconnaître le contexte (où se déroule l’action, à travers quoi...)");
        $questionnaire3->setFunction("sensible");
        $questionnaire3->setReceptionType("en tant qu’interactant  (entre 2 ou plusieurs personnes)");
        $questionnaire3->setDomain("professionnel");
        $questionnaire3->setGenre("* Bi/pluridirectionnel :  - Courtes conversations dans des contextes habituels (remerciements, présentations, excuses etc.)");
        $questionnaire3->setSourceType("construit");
        $questionnaire3->setLanguageLevel("standard");
        $questionnaire3->setDurationGroup("écoute moyenne : 21” - 40’’");
        $questionnaire3->setFlow("moyen");
        $questionnaire3->setWordCount("");
        $questionnaire3->setTheme("Bureau");
        $questionnaire3->setAuthor("");
        $questionnaire3->setConsigne("");
        $questionnaire3->setAudioConsigne("");
        $questionnaire3->setAudioContexte("");
        $questionnaire3->setAudioItem("");

        $manager->persist($questionnaire3);




        $manager->flush();
    }
}