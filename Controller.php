<?php
////==============================================////
////																				      ////
////             Контроллер D-пакета		  	      ////
////																							////
////==============================================////


/**
 *
 *
 *     HTTP-метод   Имя API     Ключ              Защита   Описание
 * ------------------------------------------------------------------------------------------------------------
 * Стандартные операции
 *
 *     GET          GET-API     любой get-запрос           Обработка всех GET-запросов
 *     POST         POST-API    любой post-запрос          Обработка всех POST-запросов
 *
 * ------------------------------------------------------------------------------------------------------------
 * Нестандартные POST-операции
 *
 *                  POST-API1   D10001:1              (v)      Описание
 *                  POST-API2   D10001:2              (v)      Описание
 *
 *
 *
 */


//-------------------------------//
// Пространство имён контроллера //
//-------------------------------//

  namespace D10001;


//---------------------------------//
// Подключение необходимых классов //
//---------------------------------//

  // Классы, поставляемые Laravel
  use Illuminate\Routing\Controller as BaseController,
      Illuminate\Support\Facades\App,
      Illuminate\Support\Facades\Artisan,
      Illuminate\Support\Facades\Auth,
      Illuminate\Support\Facades\Blade,
      Illuminate\Support\Facades\Bus,
      Illuminate\Support\Facades\Cache,
      Illuminate\Support\Facades\Config,
      Illuminate\Support\Facades\Cookie,
      Illuminate\Support\Facades\Crypt,
      Illuminate\Support\Facades\DB,
      Illuminate\Database\Eloquent\Model,
      Illuminate\Support\Facades\Event,
      Illuminate\Support\Facades\File,
      Illuminate\Support\Facades\Hash,
      Illuminate\Support\Facades\Input,
      Illuminate\Foundation\Inspiring,
      Illuminate\Support\Facades\Lang,
      Illuminate\Support\Facades\Log,
      Illuminate\Support\Facades\Mail,
      Illuminate\Support\Facades\Password,
      Illuminate\Support\Facades\Queue,
      Illuminate\Support\Facades\Redirect,
      Illuminate\Support\Facades\Redis,
      Illuminate\Support\Facades\Request,
      Illuminate\Support\Facades\Response,
      Illuminate\Support\Facades\Route,
      Illuminate\Support\Facades\Schema,
      Illuminate\Support\Facades\Session,
      Illuminate\Support\Facades\Storage,
      Illuminate\Support\Facades\URL,
      Illuminate\Support\Facades\Validator,
      Illuminate\Support\Facades\View;

  // Модели и прочие классы



//------------//
// Контроллер //
//------------//
class Controller extends BaseController {

  //-------------------------------------------------//
  // ID пакета, которому принадлежит этот контроллер //
  //-------------------------------------------------//
  public $packid = "D10001";
  public $layoutid = "L10000";

  //--------------------------------------//
  // GET-API. Обработка всех GET-запросов //
  //--------------------------------------//
  public function getIndex() {

    // 1. Выполнить задачу




    // N. Вернуть клиенту представление и данные $data
    return View::make($this->packid.'::view', ['data' => json_encode([

      'document_locale'       => r1_get_doc_locale($this->packid),
      'auth'                  => session('auth_cache') ?: '',
      'packid'                => $this->packid,
      'layoutid'              => $this->layoutid,

    ]), 'layoutid' => $this->layoutid.'::layout']);



  } // конец getIndex()


  //----------------------------------------//
  // POST-API. Обработка всех POST-запросов //
  //----------------------------------------//
  public function postIndex() {

    //------------------------------------------//
    // 1] Получить значение опций key и command //
    //------------------------------------------//
    // - $key       - ключ операции (напр.: D10001:1)
    // - $command   - полный путь команды, которую требуется выполнить
    $key        = Input::get('key');
    $command    = Input::get('command');


    //----------------------------------------//
    // 2] Обработка стандартных POST-запросов //
    //----------------------------------------//
    // - Это около 99% всех POST-запросов.
    if(empty($key) && !empty($command)) {

      // 1. Получить присланные данные

        // Получить данные data
        $data = Input::get('data');   // массив


      // 2. Выполнить команду и получить результаты
      $response = runcommand(

          $command,                   // Какую команду выполнить
          $data,                      // Какие данные передать команде
          lib_current_user_id()       // ID пользователя, от чьего имени выполнить команду

      );


      // 3. Добавить к $results значение timestamp поступления запроса
      $response['timestamp'] = $data['timestamp'];


      // 4. Сформировать ответ и вернуть клиенту
      return Response::make(json_encode($response, JSON_UNESCAPED_UNICODE));

    }


    //------------------------------------------//
    // 3] Обработка нестандартных POST-запросов //
    //------------------------------------------//
    // - Очень редко алгоритм из 2] не подходит.
    // - Например, если надо принять файл.
    // - Тогда $command надо оставить пустой.
    // - А в $key прислать ключ-код номер операции.
    if(!empty($key) && empty($command)) {

      //-----------------------------//
      // Нестандартная операция D10001:1 //
      //-----------------------------//
      if($key == 'D10001:1') {



      }


    }

  } // конец postIndex()


}?>