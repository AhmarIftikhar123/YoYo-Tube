<?php
namespace Src\App\Models\Search;

use Src\App\Modle;
class SearchSuggestionModal extends Modle
{
          public function getSuggestions($query):array
          {
                    try {
                              $sql = "SELECT DISTINCT tags FROM videos WHERE tags LIKE :query";
                              $stmt = $this->db->prepare($sql);
                              $stmt->execute(['query' => "%$query%"]);
                              $tags = $stmt->fetchAll();

                              if (!$tags) {
                                        throw new \Exception("No Suggestions found");
                              }
                              // Flatten tags into a single array
                              $suggestions = [];
                              foreach ($tags as $tagRow) {
                                        /**
                                         * Explode the comma separated tags into a single array
                                         * remove double quotes by trim bcz DB response is like
                                         * '"tag1, tag2, tag3"'
                                         * @param string $tagRow['tags']
                                         *
                                         * @return array
                                         */
                                        $tagList = explode(',', trim($tagRow['tags'], '"'));
                                        foreach ($tagList as $tag) {
                                                  if (stripos($tag, $query) !== false) {
                                                            $suggestions[] = trim($tag);
                                                  }
                                        }
                              }
                              return array_unique($suggestions);
                    } catch (\Exception $e) {
                              throw $e;
                    }
          }
}