<div class="sidebar" data-color="orange" data-background-color="white" data-image="{{ asset('material') }}/img/sidebar-1.jpg">
  <!--
      Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

      Tip 2: you can also add an image using data-image tag
  -->

  <?php

  use App\Models\Setting;

  $settings = Setting::find(1);
  $webName = $settings->web_name;

  ?>

  <div class="logo">
    <a href="/" class="simple-text logo-normal">
      {{ $webName }}
    </a>
  </div>
  <div class="sidebar-wrapper">
    <ul class="nav">
      <li class="nav-item{{ $activePage == 'dashboard' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('dashboard') }}">
          <i class="material-icons">dashboard</i>
          <p>{{ __('Dashboard') }}</p>
        </a>
      </li>

      <li class="nav-item{{ $activePage == 'users' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('users.index') }}">
          <i class="material-icons">supervisor_account</i>
          <p>{{ __('Users') }}</p>
        </a>
      </li>

      <li class="nav-item {{ ($_SERVER['REQUEST_URI'] == '/questions'  || $_SERVER['REQUEST_URI'] == '/categories'  ||$_SERVER['REQUEST_URI'] == '/tags' ) ? ' active' : '' }}">
        <a class="nav-link" data-toggle="collapse" href="#laravelExample" aria-expanded="false">
          <i class="material-icons">question_answer</i>
          <p>{{ __('Questions') }}
            <b class="caret"></b>
          </p>
        </a>
        <div class="collapse {{ ($_SERVER['REQUEST_URI'] == '/questions'  || $_SERVER['REQUEST_URI'] == '/categories'  ||$_SERVER['REQUEST_URI'] == '/tags') ? ' show' : 'hide' }}" id="laravelExample">
          <ul class="nav">
            <li class="nav-item{{ $_SERVER['REQUEST_URI'] == '/questions' ? ' active' : '' }}">
              <a class="nav-link" href="/questions">
                <span class="sidebar-normal">{{ __('All Questions') }} </span>
              </a>
            </li>
            <li class="nav-item{{ $_SERVER['REQUEST_URI'] == '/categories' ? ' active' : '' }}">
              <a class="nav-link" href="/categories">
                <span class="sidebar-normal">{{ __('Question Categories') }} </span>
              </a>
            </li>
            <li class="nav-item{{ $_SERVER['REQUEST_URI'] == '/tags' ? ' active' : '' }}">
              <a class="nav-link" href="/tags">
                <span class="sidebar-normal">{{ __('Question Tags') }} </span>
              </a>
            </li>
          </ul>
        </div>
      </li>

      <li class="nav-item {{ ($_SERVER['REQUEST_URI'] == '/omments' || $_SERVER['REQUEST_URI'] == '/answers' || $_SERVER['REQUEST_URI'] == '/replies' ) ? ' active' : '' }}">
        <a class="nav-link" data-toggle="collapse" href="#commentscollapse" aria-expanded="false">
          <i class="material-icons">chat</i>
          <p>{{ __('Comments') }}
            <b class="caret"></b>
          </p>
        </a>
        <div class="collapse {{ ($_SERVER['REQUEST_URI'] == '/comments' || $_SERVER['REQUEST_URI'] == '/answers'  || $_SERVER['REQUEST_URI'] == '/replies') ? ' show' : 'hide' }}" id="commentscollapse">
          <ul class="nav">
            <li class="nav-item{{ $_SERVER['REQUEST_URI'] == '/comments' ? ' active' : '' }}">
              <a class="nav-link" href="/comments">
                <span class="sidebar-normal">{{ __('All Comments') }} </span>
              </a>
            </li>
            <li class="nav-item{{ $_SERVER['REQUEST_URI'] == '/answers' ? ' active' : '' }}">
              <a class="nav-link" href="/answers">
                <span class="sidebar-normal">{{ __('Answers') }} </span>
              </a>
            </li>
            <li class="nav-item{{ $_SERVER['REQUEST_URI'] == '/replies' ? ' active' : '' }}">
              <a class="nav-link" href="/replies">
                <span class="sidebar-normal">{{ __('Replies') }} </span>
              </a>
            </li>
          </ul>
        </div>
      </li>

      <li class="nav-item {{ ($_SERVER['REQUEST_URI'] == '/all-reports' || $_SERVER['REQUEST_URI'] == '/question-reports' || $_SERVER['REQUEST_URI'] == '/answer-reports' ) ? ' active' : '' }}">
        <a class="nav-link" data-toggle="collapse" href="#reportscollapse" aria-expanded="false">
          <i class="material-icons">flag</i>
          <p>{{ __('Reports') }}
            <b class="caret"></b>
          </p>
        </a>
        <div class="collapse {{ ($_SERVER['REQUEST_URI'] == '/all-reports'  || $_SERVER['REQUEST_URI'] == '/question-reports' || $_SERVER['REQUEST_URI'] == '/answer-reports' ) ? ' show' : 'hide' }}" id="reportscollapse">
          <ul class="nav">
            <li class="nav-item{{ $_SERVER['REQUEST_URI'] == '/all-reports' ? ' active' : '' }}">
              <a class="nav-link" href="/all-reports">
                <span class="sidebar-normal">{{ __('All Reports') }} </span>
              </a>
            </li>
            <li class="nav-item{{ $_SERVER['REQUEST_URI'] == '/question-reports' ? ' active' : '' }}">
              <a class="nav-link" href="/question-reports">
                <span class="sidebar-normal">{{ __('Questions') }} </span>
              </a>
            </li>
            <li class="nav-item{{ $_SERVER['REQUEST_URI'] == '/answer-reports' ? ' active' : '' }}">
              <a class="nav-link" href="/answer-reports">
                <span class="sidebar-normal">{{ __('Answers') }} </span>
              </a>
            </li>
          </ul>
        </div>
      </li>

      <li class="nav-item{{ $activePage == 'messages' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('messages.index') }}">
          <i class="material-icons">mail</i>
          <p>{{ __('Messages') }}</p>
        </a>
      </li>

      <!-- <li class="nav-item{{ $activePage == 'badges' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('badges.index') }}">
          <i class="material-icons">emoji_events</i>
          <p>{{ __('Badges') }}</p>
        </a>
      </li> -->

      <li class="nav-item{{ $activePage == 'points' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('points.index') }}">
          <i class="material-icons">filter_1</i>
          <p>{{ __('Points') }}</p>
        </a>
      </li>

      <li class="nav-item{{ $activePage == 'notifications' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('notifications.index') }}">
          <i class="material-icons">notifications</i>
          <p>{{ __('Notifications') }}</p>
        </a>
      </li>

      <li class="nav-item {{ ($activePage == 'site-info' || $activePage == 'app-info' || $activePage == 'push-notifications') ? ' active' : '' }}">
        <a class="nav-link" data-toggle="collapse" href="#settingsdropdown" aria-expanded="false">
          <i class="material-icons">settings</i>
          <p>{{ __('Settings') }}
            <b class="caret"></b>
          </p>
        </a>

        <div class="collapse {{ ( $activePage == 'app-info' || $activePage == 'push-notifications') ? ' show' : 'hide' }}" id="settingsdropdown">
          <ul class="nav">
            <li class="nav-item{{ $activePage == 'app-info' ? ' active' : '' }}">
              <a class="nav-link" href="/app-info">
                <i class="material-icons">settings_cell</i>
                <span class="sidebar-normal"> {{ __('App Info') }} </span>
              </a>
            </li>
            <li class="nav-item{{ $activePage == 'web-info' ? ' active' : '' }}">
              <a class="nav-link" href="/web-info">
                <i class="material-icons">language</i>
                <span class="sidebar-normal"> {{ __('Web Info') }} </span>
              </a>
            </li>
            <li class="nav-item{{ $activePage == 'push-notifications' ? ' active' : '' }}">
              <a class="nav-link" href="/push-notifications">
                <i class="material-icons">edit_notifications</i>
                <span class="sidebar-normal"> {{ __('Push Notifications') }} </span>
              </a>
            </li>
          </ul>
        </div>
      </li>

    </ul>
  </div>
</div>