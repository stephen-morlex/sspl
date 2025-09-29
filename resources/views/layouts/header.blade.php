<div class="navbar bg-base-100 text-base-content shadow-sm sticky top-0 z-40">
  <div class="navbar-start">
    <div class="dropdown">
      <div tabindex="0" role="button" class="btn btn-ghost lg:hidden">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h8m-8 6h16" />
        </svg>
      </div>
      <ul tabindex="0" class="menu menu-sm dropdown-content bg-base-100 rounded-box z-1 mt-3 w-52 p-2 shadow">
        <li><a href="{{ route('matches') }}">Matches</a></li>
        <li><a href="{{ route('standings') }}">Table</a></li>
        <li><a href="{{ route('teams.index') }}">Teams</a></li>
        <li><a href="{{ route('players.index') }}">Players</a></li>
        <li><a href="{{ route('news.index') }}">News</a></li>
      </ul>
    </div>
    <a href="{{ route('home') }}" class="flex items-center gap-2 btn btn-ghost text-xl">
        <img class="h-8 w-8 rounded-full" src="/images/logo.png" alt="Logo">
        <span class="hidden sm:block">SSPL</span>
    </a>
  </div>
  <div class="navbar-center hidden lg:flex">
    <ul class="menu menu-horizontal px-1">
      <li><a href="{{ route('matches') }}">Matches</a></li>
      <li><a href="{{ route('standings') }}">Table</a></li>
      <li><a href="{{ route('teams.index') }}">Teams</a></li>
      <li><a href="{{ route('players.index') }}">Players</a></li>
      <li><a href="{{ route('news.index') }}">News</a></li>
    </ul>
  </div>
  <div class="navbar-end">
    <button type="button" class="btn btn-ghost btn-sm mr-2 hidden sm:flex">
      <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <circle cx="11" cy="11" r="7" />
        <path d="m21 21-4.3-4.3" />
      </svg>
      <span class="hidden md:inline">Search</span>
    </button>
    <!-- Theme Toggle Switch -->
    <label class="swap swap-rotate">
      <!-- this hidden checkbox controls the state -->
      <input type="checkbox" data-toggle-theme="light,dark" data-act-class="ACTIVECLASS" aria-label="Toggle theme" />

      <!-- sun icon -->
      <svg
        class="swap-on h-4 w-4 fill-current"
        xmlns="http://www.w3.org/2000/svg"
        viewBox="0 0 24 24">
        <path
          d="M5.64,17l-.71.71a1,1,0,0,0,0,1.41,1,1,0,0,0,1.41,0l.71-.71A1,1,0,0,0,5.64,17ZM5,12a1,1,0,0,0-1-1H3a1,1,0,0,0,0,2H4A1,1,0,0,0,5,12Zm7-7a1,1,0,0,0,1-1V3a1,1,0,0,0-2,0V4A1,1,0,0,0,12,5ZM5.64,7.05a1,1,0,0,0,.7.29,1,1,0,0,0,.71-.29,1,1,0,0,0,0-1.41l-.71-.71A1,1,0,0,0,4.93,6.34Zm12,.29a1,1,0,0,0,.7-.29l.71-.71a1,1,0,1,0-1.41-1.41L17,5.64a1,1,0,0,0,0,1.41A1,1,0,0,0,17.66,7.34ZM21,11H20a1,1,0,0,0,0,2h1a1,1,0,0,0,0-2Zm-9,8a1,1,0,0,0-1,1v1a1,1,0,0,0,2,0V20A1,1,0,0,0,12,19ZM18.36,17A1,1,0,0,0,17,18.36l.71.71a1,1,0,0,0,1.41,0,1,1,0,0,0,0-1.41ZM12,6.5A5.5,5.5,0,1,0,17.5,12,5.51,5.51,0,0,0,12,6.5Zm0,9A3.5,3.5,0,1,1,15.5,12,3.5,3.5,0,0,1,12,15.5Z" />
      </svg>

      <!-- moon icon -->
      <svg
        class="swap-off h-4 w-4 fill-current"
        xmlns="http://www.w3.org/2000/svg"
        viewBox="0 0 24 24">
        <path
          d="M21.64,13a1,1,0,0,0-1.05-.14,8.05,8.05,0,0,1-3.37.73A8.15,8.15,0,0,1,9.08,5.49a8.59,8.59,0,0,1,.25-2A1,1,0,0,0,8,2.36,10.14,10.14,0,1,0,22,14.05,1,1,0,0,0,21.64,13Zm-9.5,6.69A8.14,8.14,0,0,1,7.08,5.22v.27A10.15,10.15,0,0,0,17.22,15.63a9.79,9.79,0,0,0,2.1-.22A8.11,8.11,0,0,1,12.14,19.73Z" />
      </svg>
    </label>
  </div>
</div>

@if(request()->is('/'))
    <livewire:news-ticker />
@endif
