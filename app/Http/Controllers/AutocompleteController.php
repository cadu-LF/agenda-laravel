<?php

namespace App\Http\Controllers;

use App\Model\Contact;
use Illuminate\Http\Request;

class AutocompleteController extends Controller
{
    public function autocomplete(Request $request)
    {
        if ($request->get('query')) {
            $query = $request->get('query');
            $data = Contact::select('fullname')
                            ->where('fullname', 'LIKE', "%{$query}%")
                            ->get();
            $output = '<ul class="dropdown-menu" style="display:block; position:relative">';
            foreach ($data as $row) {
                $output .= '
                <li><a href="#">' . $row->fullname . '</a></li>
                ';
            }
            $output .= '</ul>';
            echo $output;
        }
    }
}
