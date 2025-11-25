<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\ContactRequest;
use Normalizer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class ContactController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function confirm(ContactRequest $request)
    {
        $contact = $request->all();

        $frontTel = implode(",", $request->only(['front-tel']));
        $middleTel = implode(",", $request->only(['middle-tel']));
        $backTel = implode(",", $request->only(['back-tel']));
        $entireTel = $frontTel . $middleTel . $backTel;

        $lastName = implode(",", $request->only(['last_name']));
        $firstName = implode(",", $request->only(['first_name']));
        $fullName = $lastName . " " . $firstName;

        return view('confirm', ['contact' => $contact, 'entireTel' => $entireTel, 'fullName' => $fullName]);
    }

    public function store(Request $request)
    {
        if ($request->get('action') === 'modify') {
            return redirect()->route('rewrite')->withInput();
        }

        $contact = $request->only([
            'category_id',
            'first_name',
            'last_name',
            'gender',
            'email',
            'tel',
            'address',
            'building',
            'detail',
        ]);

        $genderType = implode(",", $request->only('gender'));
        if ($genderType == "男性") {
            $contact['gender'] = 1;
        } elseif ($genderType == "女性") {
            $contact['gender'] = 2;
        } elseif ($genderType == "その他") {
            $contact['gender'] = 3;
        }

        $categoryType = implode(",", $request->only(['category_id']));
        if ($categoryType == "商品のお届けについて") {
            $contact['category_id'] = 1;
        } elseif ($categoryType == "商品の交換について") {
            $contact['category_id'] = 2;
        } elseif ($categoryType == "商品トラブル") {
            $contact['category_id'] = 3;
        } elseif ($categoryType == "ショップへのお問い合わせ") {
            $contact['category_id'] = 4;
        } elseif ($categoryType == "その他") {
            $contact['category_id'] = 5;
        }

        Contact::create($contact);
        return view('thanks');
    }

    public function admin()
    {
        $contacts = Contact::Paginate(10);

        for ($i = 0; $i < count($contacts); $i++) {
            $gender_type = $contacts[$i]['gender'];
            if ($gender_type == 1) {
                $contacts[$i]['gender'] = "男性";
            } elseif ($gender_type == 2) {
                $contacts[$i]['gender'] = "女性";
            } elseif ($gender_type == 3) {
                $contacts[$i]['gender'] = "その他";
            }
        }
        return view('admin', ['contacts' => $contacts]);
    }

    public function search(Request $request)
    {
        $query = Contact::query();
        $contacts = $request->all();
        $model = new Contact();
        $columnsCount = count($model->getConnection()->getSchemaBuilder()->getColumnListing($model->getTable()));

        $name_email_filter = $request->name_email_filter;
        $gender_dropdown = $request->gender_dropdown;
        $category_dropdown = $request->category_dropdown;
        $date_calendar = $request->date_calendar;

        if (!empty($name_email_filter)) {
            $normalized_filter = Normalizer::normalize($name_email_filter, Normalizer::FORM_C);

            $query->where(function ($query) use ($normalized_filter) {
                $query->where(Contact::raw("CONCAT(last_name,first_name)"), 'like', '%' . $normalized_filter . '%');
            })
            ->orWhere('email', 'like', '%' . $normalized_filter . '%');
        }
        if (!empty($gender_dropdown)) {
            $query->where('gender', $gender_dropdown);
        }
        if (!empty($category_dropdown)) {
            $query->where('category_id', $category_dropdown);
        }
        if (!empty($date_calendar)) {
            $query->whereDate('created_at', '=', $date_calendar);
        }



        $contacts = $query->Paginate(10);

        if (!empty($contacts)) {
            for ($i = 0; $i < $columnsCount; $i++) {
                if (isset($contacts[$i]['gender'])) {
                    $gender_type = $contacts[$i]['gender'];
                    if ($gender_type == 1) {
                        $contacts[$i]['gender'] = "男性";
                    } elseif ($gender_type == 2) {
                        $contacts[$i]['gender'] = "女性";
                    } elseif ($gender_type == 3) {
                        $contacts[$i]['gender'] = "その他";
                    }
                }
            }
        }

        return view('admin', ['contacts' => $contacts]);
    }

    public function delete(Request $request)
    {
        $contact = Contact::findOrFail($request->id);
        $contact->delete();
        return redirect('/admin');
    }
}
