<?php
namespace Src\App\Controllers\Search;
use Src\App\Models\Search\SearchSuggestionModal;

class SearchSuggestionsController
{
          protected SearchSuggestionModal $SearchSuggestionsModel;
          public function __construct()
          {
                    $this->SearchSuggestionsModel = new SearchSuggestionModal();
          }

          public function getSearchSuggestions()
          {
                    header('Content-Type: application/json');
                    try {
                              if ($_SERVER['REQUEST_METHOD'] === "POST") {
                                        $query = $_POST['query'];
                                        $suggestions = $this->SearchSuggestionsModel->getSuggestions($query);

                                        echo json_encode(["success" => true, 'suggestions' => $suggestions]);
                              }
                    } catch (\Exception $e) {
                              echo json_encode(["success" => false, "message" => $e->getMessage()]);
                              exit();
                    }
          }
}