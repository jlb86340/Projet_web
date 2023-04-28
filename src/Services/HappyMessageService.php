<?php

namespace App\Services;

class HappyMessageService
{
    public function getHappyMessage(): string
    {
        $messages = [
            'Quelle mamie fait peur aux voleurs ? Mamie Traillette.',
            'Pourquoi est-ce si difficile de conduire dans le Nord ? Parce que les voitures n’arrêtent pas de caler. (Pas-de-Calais)',
            'Que faisaient les dinosaures quand ils n\'arrivaient pas à se décider ? Des tirageosaures.',
            'Pourquoi est-ce qu\'il faut mettre tous les crocos en prison ? Parce que les crocos dealent.',
            'Pourquoi dit-on que les poissons travaillent illégalement ? Parce qu’ils n’ont pas de FISH de paie.',
            'Qu\'est-ce qu\'un tennisman adore faire ? Rendre des services.',
            'Pourquoi est-ce que les livres ont-ils toujours chaud ? Parce qu’ils ont une couverture.',
            'Où est-ce que les super-héros vont-ils faire leurs courses ? Au supermarché.',
            'Que se passe-t-il quand 2 poissons s\'énervent ? Le thon monte.',
            'Quel fruit est assez fort pour couper des arbres ? Le citron.',
            'Quel est le jambon que tout le monde déteste ? Le sale ami.',
            'Que fait un cendrier devant un ascenseur ? Il veut des cendres.',
            'Quel est l\'aliment le plus hilarant ? Le riz.',
            'Pourquoi les girafes n\'existent pas ? Parce que c’est un coup monté.',
        ];

        $index = array_rand($messages);

        return $messages[$index];
    }
}
