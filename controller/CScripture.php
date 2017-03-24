<?php

use Doctrine\Common\Collections\Criteria;

class CScripture
{
    static public function action_lookup( $route, $params )
    {
        $view = new View( $route );
        if ( isset( $params[0] ) && isset( $params[1] ) ) {
            $book = $params[0];
            $chapter = $params[1];
            if ( isset( $params[2] ) )
                $verses = explode( ',', $params[2] );
            else
                $verses = null;

            $scripture = new MScripture( $book, $chapter, $verses );

            $view->setVar( 'scripture', $scripture );
        }
        $view->display();
    }

    static public function action_view( $route, $params )
    {
        $view = new View( $route );
        $crumbRoot = GlobalConfig::getAppPath() . '/scripture/view';
        $rootName = 'Books';
        if ( isset( $params[0] ) && isset( $params[1] ) ) {
            $verses = array();
            $book = $params[0];
            $mBook = MScripture::findBook( $book );
            $chapter = $params[1];
            $volume = MScripture::getVolumesRepo()->find( $mBook->getVolumeId() );
            /* @var Volumes $volume */
            if ( isset( $params[2] ) && $params[2] != '' )
                $verses = explode( ',', $params[2] );

            $chapterName = 'Chapter ' . $chapter;
            $breadcrumb = array(
                $volume->getTitle() => $crumbRoot . '?volume=' . $volume->getId(),
                $mBook->getTitle()  => $crumbRoot . '/' . $book,
                $chapterName        => $crumbRoot . '/' . $book . '/' . $chapter
            );
            $activeCrumb = $chapterName;

            $verses = MScripture::explodeRanges( $verses );

            $scripture = new MScripture( $book, $chapter );

            $view->setVar( 'scripture', $scripture )
                 ->setVar( 'verses', $verses )
                 ->setVar( 'activeCrumb', $activeCrumb )
                 ->setVar( 'breadcrumb', $breadcrumb );
            $view->display();
        } else if ( isset( $params[0] ) ) {
            $view = new View( $route );

            $book = MScripture::findBook( $params[0] );
            /* @var Books $book */
            $volume = MScripture::getVolumesRepo()->find( $book->getVolumeId() );
            /* @var Volumes $volume */
            $chapters = MScripture::getChaptersRepo()->findBy( array( 'bookId' => $book->getId() ) );

            $bookTitle = $book->getTitle();
            $breadcrumb = array(
                $volume->getTitle() => $crumbRoot . '?volume=' . $volume->getId(),
                $bookTitle          => $crumbRoot . '/' . $book->getLdsUrl(),
            );
            $activeCrumb = $bookTitle;

            $view->setVar( 'book', $book )
                 ->setVar( 'volume', $volume )
                 ->setVar( 'chapters', $chapters )
                 ->setVar( 'activeCrumb', $activeCrumb )
                 ->setVar( 'breadcrumb', $breadcrumb )
                 ->setVar( 'viewPath', 'scripture/chapter-list.php' );
            $view->display();
        } else {
            if ( isset( $_GET['volume'] ) && is_numeric( $_GET['volume'] ) )
                $active = MScripture::getVolumesRepo()->find( $_GET['volume'] );

            $view = new View( $route );

            $volumes = MScripture::getVolumesRepo()->findAll();
            $books = MScripture::getBooksRepo();

            $array = array();
            foreach ( $volumes as $volume ) /* @var Volumes $volume */ {
                $array[$volume->getTitle()] = array();
                foreach ( $books->findBy( array( 'volumeId' => $volume->getId() ) ) as $book ) /* @var Books $book */ {
                    $array[$volume->getTitle()][$book->getLdsUrl()] = $book->getTitle();
                }
            }

            $view->setVar( 'volumes', $array )
                 ->setVar( 'viewPath', 'scripture/book-list.php' );
            if ( isset( $active ) )
                $view->setVar( 'active', $active->getTitle() );
            else
                $view->setVar( 'active', '' );
            $view->display();
        }
    }

    public static function action_mostCommonWords( $route, $params )
    {
        $booksRepo = MScripture::getBooksRepo();
        $chaptersRepo = MScripture::getChaptersRepo();
        $versesRepo = MScripture::getVersesRepo();

        $threshold = 0.007;

        if ( isset( $params[0] ) )
            $volumes = MScripture::getVolumesRepo()->findBy( array( 'ldsUrl' => $params[0] ) );
        else
            $volumes = MScripture::getVolumesRepo()->findAll();

        $wordsArray = array();
        $wordCount = 0;
        foreach ( $volumes as $volume ) /* @var Volumes $volume */ {
            $books = $booksRepo->findBy( array( 'volumeId' => $volume->getId() ) );

            foreach ( $books as $book ) /* @var Books $book */ {
                $chapters = $chaptersRepo->findBy( array( 'bookId' => $book->getId() ) );

                foreach ( $chapters as $chapter ) /* @var Chapters $chapter */ {
                    $verses = $versesRepo->findBy( array( 'chapterId' => $chapter->getId() ) );

                    foreach ( $verses as $verse ) /* @var Verses $verse */ {
                        $words = WordAnalysis::explodeWords( $verse->getText() );
                        foreach ( $words as $word ) {
                            if ( array_key_exists( $word, $wordsArray ) )
                                $wordsArray[$word]++;
                            else
                                $wordsArray[$word] = 1;
                            $wordCount++;
                        }
                    }
                }
            }
        }
        echo 'words:' . $wordCount . ' ';
        arsort( $wordsArray );
        foreach ( $wordsArray as $word => $count ) {
            if ( $count / $wordCount < $threshold)
                break;
            else
                echo $word . ', ';
        }

        print_r( $wordsArray );
    }

    public static function action_findConnections( $route, $params ) {
        if ( isset( $params[0] ) && isset( $params[1] ) ) {
            $book = $params[0];
            $chapter = $params[1];
            if ( isset( $params[2] ) )
                $verses = explode( ',', $params[2] );
            else
                $verses = null;

            $versesRepo = MScripture::getVersesRepo();
            $scripture = new MScripture( $book, $chapter, $verses );

            $references = array();
            foreach ( $scripture->getVerses() as $verse ) /* @var Verses $verse */ {
                $words = WordAnalysis::countWords( $verse->getText() );
                WordAnalysis::filterWords($words);
                foreach ( $words as $word => $count ) {
                    echo "$word, ";
                    $criteria = Criteria::create();
                    $criteria->where(Criteria::expr()->contains( 'text', $word ));
                    $verses = $versesRepo->matching($criteria);
                    foreach ( $verses as $verse ) {
                        if (array_key_exists($verse->getId(), $references))
                            $references[$verse->getId()] += $count + WordAnalysis::countWord($word, $verse->getText());
                        else
                            $references[$verse->getId()] = $count + WordAnalysis::countWord($word, $verse->getText());
                    }
                }
            }
            arsort($references);
            echo '<br/>';
            foreach($references as $refId => $count)
            {
                $verse = $versesRepo->find($refId);
                echo $count . ': ';
                echo $verse->getText();
                echo '<br/>';
            }
        }
    }

    private function __construct()
    {
    }

    private function __clone()
    {
    }
}