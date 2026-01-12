<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\MenuResource;
use App\Models\Menu;
use App\Models\MenuDetail;
use App\Traits\StatusResponser;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    use StatusResponser;

    public function __construct()
    {
        $this->middleware('password_confirm')->only('destroy');
    }


    public function index()
    {
        $menus = Menu::query();

        $menus = $this->whereClause($menus);
        $menus = $this->loadRelations($menus);
        $menus = $this->sortingAndLimit($menus);

        return $this->apiSuccessResponse(MenuResource::collection($menus), 'Data Get Successfully!');
    }


    public function show(Menu $menu)
    {
        if (isset($_GET['withMenuDetail']) && $_GET['withMenuDetail'] == '1') {
            $menu = $menu->loadMissing('menuDetail');
        }

        return $this->apiSuccessResponse(new MenuResource($menu), 'Data Get Successfully!');
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            "name" => ["required", "string", "max:255"],
            "is_main_menu" => ["required", "boolean"],
            "is_top_menu" => ["required", "boolean"],
        ],[
            'name.required' => 'Menu name is required.',
        ]
    );
        $menu = Menu::create([
            'name' => $request->name,
            'is_main_menu' => $request->is_main_menu,
            'is_top_menu' => $request->is_top_menu,
        ]);

        if ($menu) {
            if ($request->is_main_menu == 1) {
                $this->removeDefaultMainMenu($menu);
            }
            if ($request->is_top_menu == 1) {
                $this->removeDefaultFooterMenu($menu);
            }
            return $this->apiSuccessResponse(new MenuResource($menu), 'Your changes have been done successfully');
        }
        return $this->errorResponse();
    }


    public function update(Request $request, Menu $menu)
    {
        $rules = [
            'id' => ['required', 'exists:App\Models\Menu,id'],
            "name" => ["required", "string", "max:255"],
            "is_main_menu" => ["required", "boolean"],
            "is_top_menu" => ["required", "boolean"],
        ];
        $messages = [
            'name.required' => 'Menu name is required.',
        ];
        $this->validate($request, $rules,$messages);
        $result = Menu::whereId($request->id)->update([
            'name' => $request->name,
            'is_main_menu' => $request->is_main_menu,
            'is_top_menu' => $request->is_top_menu,
        ]);

        if ($result) {
            if ($request->is_main_menu == 1) {
                $this->removeDefaultMainMenu($menu);
            }
            if ($request->is_top_menu == 1) {
                $this->removeDefaultFooterMenu($menu);
            }
            return $this->apiSuccessResponse(new MenuResource($menu), 'Your changes have been done successfully');
        }
        return $this->errorResponse();
    }


    public function destroy(Request $request, Menu $menu)
    {
        if ($menu->menuDetail()->delete() && $menu->delete()) {
            return $this->apiSuccessResponse(new MenuResource($menu), 'The selected item has been deleted successfully');
        }
        return $this->errorResponse();
    }

    protected function removeDefaultMainMenu($menu)
    {
        Menu::where('id', '!=', $menu->id)->update([
            'is_main_menu' => 0
        ]);
    }

    protected function removeDefaultFooterMenu($menu)
    {
        Menu::where('id', '!=', $menu->id)->update([
            'is_top_menu' => 0
        ]);
    }

    protected function loadRelations($menus)
    {
        $defaultLang = getDefaultLanguage();
        $menus = $menus->with(['menuDetail' => function ($q) use ($defaultLang) {
            $q->where('language_id', $defaultLang->id);
        }]);
        if (isset($_GET['withMenuDetail']) && $_GET['withMenuDetail'] == '1') {
            $menus = $menus->with('menuDetail');
        }
        return $menus;
    }

    protected function sortingAndLimit($menus)
    {

        $sortType = ['ASC', 'asc', 'DESC', 'desc'];
        $sortBy = ['id', 'name', 'is_main_menu', 'is_top_menu'];
        if (isset($_GET['sortBy']) && $_GET['sortBy'] != '' && isset($_GET['sortType']) && $_GET['sortType'] != '' && in_array($_GET['sortBy'], $sortBy) && in_array($_GET['sortType'], $sortType)) {
            $menus = $menus->OrderBy($_GET['sortBy'], $_GET['sortType']);
        }


        if (isset($_GET['limit']) && $_GET['limit'] != '') {
            $limit = $_GET['limit'];
        } else {
            $limit = 10;
        }

        if (isset($_GET['getAll']) && $_GET['getAll'] == '1') {
            return $menus->get();
        }

        return $menus->paginate($limit);
    }

    protected function whereClause($menus)
    {
        if (isset($_GET['searchParam']) && $_GET['searchParam'] != '') {
            $menus = $menus->where('name', 'LIKE', '%' . $_GET['searchParam'] . '%');
        }
        return $menus;
    }

    public function updateMenuBuilder(Request $request, $menuId)
    {
        $validationRule = [];
        $errorMessages = [];
        $languages = getAllLanguages();
        foreach ($languages as $language) {
            $validationRule = array_merge($validationRule, ['menu_' . $language->id => ['required', 'array', 'min:1']]);
            $errorMessages = array_merge($errorMessages, ['menu_' . $language->id . '.required' => 'Menu in ' . $language->name . ' is required.']);
            $errorMessages = array_merge($errorMessages, ['menu_' . $language->id . '.array' => 'Menu in ' . $language->name . ' must be an array.']);
            $errorMessages = array_merge($errorMessages, ['menu_' . $language->id . '.min' => 'Menu in ' . $language->name . ' must have atleast one item.']);
        }

        $this->validate(
            $request,
            $validationRule,
            $errorMessages
        );

        foreach ($languages as $language) {
            $menuDetail = MenuDetail::whereMenuId($menuId)->whereLanguageId($language->id)->exists();
            if ($menuDetail) {
                MenuDetail::whereMenuId($menuId)->whereLanguageId($language->id)->update([
                    'menu_items' => $request['menu_' . $language->id],
                ]);
            } else {
                MenuDetail::create([
                    'menu_id' => $menuId,
                    'language_id' => $language->id,
                    'menu_items' => json_encode($request['menu_' . $language->id]),
                ]);
            }
        }
        return $this->successResponse([], 'Menu has been updated successfully.');
    }
}
