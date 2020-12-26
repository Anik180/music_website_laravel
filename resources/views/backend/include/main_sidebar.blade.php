@php
$seos=DB::table('seos')->get();
@endphp
Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ url('admin/dashboard') }}" class="brand-link">
        <img src="{{ asset('public/backend/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">{{-- {{ config('app.name') }} --}}Epic Music</span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('public/backend/dist/img/default_user.png') }}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ Auth::user()->name }}</a>
            </div>
        </div>
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                @if(Auth::user()->level == 1)
                <li class="nav-item has-treeview {{ (isset($menu)&&$menu=='home')?'menu-open':'' }}">
                    <a href="#" class="nav-link {{ (isset($menu)&&$menu=='home')?'active':'' }}">
                        <i class="nav-icon fa fa-home"></i>
                        <p>
                            Home
                            
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('slider.index') }}" class="nav-link {{ (isset($sub_menu)&&$sub_menu=='slider')?'active':'' }}">
                                <i class="fas fa-caret-right nav-icon"></i>
                                <p>Videos</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('admin/seo-show?seo_menu=home&main_menu=home&sub_menu=expertise&section=header') }}" class="nav-link {{ (isset($sub_menu)&&$sub_menu=='expertise')?'active':'' }}">
                                <i class="fas fa-caret-right nav-icon"></i>
                                <p>Expertise</p>
                            </a>
                        </li>
                        <li class="nav-item" style="margin-left: 10px">
                            <a href="{{ route('our-expertise.index') }}" class="nav-link {{ (isset($sub_menu)&&$sub_menu=='our_expertise')?'active':'' }}">
                                <i class="fas fa-caret-right nav-icon"></i>
                                <p>Pictures & Links</p>
                            </a>
                        </li>
                        <li class="nav-item" style="margin-left: 10px">
                            <a href="{{ url('admin/credits') }}" class="nav-link {{ (isset($sub_menu)&&$sub_menu=='credit')?'active':'' }}">
                                <i class="fas fa-caret-right nav-icon"></i>
                                <p>Credits</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a  href="{{ url('admin/seo-show?seo_menu=home&main_menu=home&sub_menu=why_choose_epic&section=footer') }}" class="nav-link {{ (isset($sub_menu)&&$sub_menu=='why_choose_epic')?'active':'' }}">
                                <i class="fas fa-caret-right nav-icon"></i>
                                <p>Why choose Epic</p>
                            </a>
                        </li>
                    </ul>
                </li>
                        <li class="nav-item has-treeview  {{ (isset($menu)&&$menu=='sports')?'menu-open':'' }}">
                    <!--<a href="#" class="nav-link ">-->
                    <!--    <i class="nav-icon fa fa-users"></i>-->
                    <!--    <p>-->
                    <!--       Sports-->
                    <!--        <i class="right fas fa-angle-left"></i>-->
                    <!--    </p>-->
                    <!--</a>-->
                    
                    
                      <a href="#" class="nav-link {{ (isset($menu)&&$menu=='sports')?'active':'' }}">
                        <i class="nav-icon fa fa-home"></i>
                        <p>
                            Sports
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                         <li class="nav-item">
                            <a  href="{{ url('admin/sports') }}" class="nav-link {{ (isset($sub_menu)&&$sub_menu=='all_sports')?'active':'' }}">
                                <i class="fas fa-caret-right nav-icon"></i>
                                <p>All Sports</p>
                            </a>
                  
                        </li>
                         <li class="nav-item">
                            <a  href="{{ url('admin/seo-show?seo_menu=sports_music_library&main_menu=sports&sub_menu=sports_music_library&section=header') }}" class="nav-link {{ (isset($sub_menu)&&$sub_menu=='sports_music_library')?'active':'' }}">
                                <i class="fas fa-caret-right nav-icon"></i>
                                <p>Sports Music Library</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a  href="{{ url('admin/seo-show?seo_menu=sports_music_library&main_menu=sports&sub_menu=b_sports_music_library&section=footer') }}" class="nav-link {{ (isset($sub_menu)&&$sub_menu=='b_sports_music_library')?'active':'' }}">
                                <i class="fas fa-caret-right nav-icon"></i>
                                <p>Best Sports Music Library</p>
                            </a>
                        </li>
                  <li class="nav-item">
                    <a href="{{ url('admin/sports-artist') }}" class="nav-link {{ (isset($sub_menu)&&$sub_menu=='Sports_artist_list')?'active':'' }}">
                        <i class="nav-icon fas fa-caret-right"></i>
                        <p>Sports Artist</p>
                    </a>
                </li>
                 <!--<li class="nav-item">-->
                 <!--           <a href="{{route('sport.team')}}" class="nav-link {{ (isset($sub_menu)&&$sub_menu=='composer_sports')?'active':'' }}">-->
                 <!--               <i class="fas fa-caret-right nav-icon"></i>-->
                 <!--               <p>Sports Composer team</p>-->
                 <!--           </a>-->
                 <!--       </li>-->
                    </ul>
                </li>
                <li class="nav-item has-treeview {{ (isset($menu)&&$menu=='our_team')?'menu-open':'' }}">
                    <a href="#" class="nav-link {{ (isset($menu)&&$menu=='our_team')?'active':'' }}">
                        <i class="nav-icon fa fa-users"></i>
                        <p>
                            Our Team
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ url('admin/seo-show?seo_menu=our_team&main_menu=our_team&sub_menu=about_team&section=header') }}" class="nav-link {{ (isset($sub_menu)&&$sub_menu=='about_team')?'active':'' }}">
                                <i class="fas fa-caret-right nav-icon"></i>
                                <p>About Team</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('our-team.index') }}" class="nav-link {{ (isset($sub_menu)&&$sub_menu=='sub_our_team')?'active':'' }}">
                                <i class="fas fa-caret-right nav-icon"></i>
                                <p>Team List</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item has-treeview {{ (isset($menu)&&$menu=='epic_artist')?'menu-open':'' }}">
                    <a href="#" class="nav-link {{ (isset($menu)&&$menu=='epic_artist')?'active':'' }}">
                        <i class="nav-icon fa fa-guitar"></i>
                        <p>
                            Epic Artists / Band
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ url('admin/seo-show?seo_menu=artist&main_menu=epic_artist&sub_menu=artist&section=header') }}" class="nav-link {{ (isset($sub_menu)&&$sub_menu=='artist')?'active':'' }}">
                                <i class="fas fa-caret-right nav-icon"></i>
                                <p>About Epic Artists / Band</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ (isset($sub_menu)&&$sub_menu=='sub_epic_artist')?'active':'' }}" href="{{ route('epicArtists.index') }}">
                                <i class="fas fa-caret-right nav-icon"></i>
                                <p>Epic Artists / Band List</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item has-treeview {{ (isset($menu)&&$menu=='giving_back')?'menu-open':'' }}">
                    <a href="#" class="nav-link {{ (isset($menu)&&$menu=='giving_back')?'active':'' }}">
                        <i class="nav-icon fa fa-file"></i>
                        <p>
                            Giving Back
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ url('admin/philanthropies') }}" class="nav-link {{ (isset($sub_menu)&&$sub_menu=='philanthropy')?'active':'' }}">
                                <i class="fas fa-caret-right nav-icon"></i>
                                <p>Philanthropy</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('admin/education-internships') }}" class="nav-link {{ (isset($sub_menu)&&$sub_menu=='education_internship')?'active':'' }}">
                                <i class="fas fa-caret-right nav-icon"></i>
                                <p>Education & Internships</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('admin/interested-in-working') }}" class="nav-link {{ (isset($sub_menu)&&$sub_menu=='interested-in-working')?'active':'' }}">
                                <i class="fas fa-caret-right nav-icon"></i>
                                <p>Interested In Working</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item has-treeview {{ (isset($menu)&&$menu=='why_epic')?'menu-open':'' }}">
                    <a href="#" class="nav-link {{ (isset($menu)&&$menu=='why_epic')?'active':'' }}">
                        <i class="nav-icon fa fa-question"></i>
                        <p>
                            Why Epic
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ url('admin/why-epic-list') }}" class="nav-link {{ (isset($sub_menu)&&$sub_menu=='why_epic_list')?'active':'' }}">
                                <i class="fas fa-caret-right nav-icon"></i>
                                <p>Why Epic List</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('admin/why-epic-create') }}" class="nav-link {{ (isset($sub_menu)&&$sub_menu=='why_epic_create')?'active':'' }}">
                                <i class="fas fa-caret-right nav-icon"></i>
                                <p>Add Why Epic</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('admin/why-epic/client-say') }}" class="nav-link {{ (isset($sub_menu)&&$sub_menu=='client_say')?'active':'' }}">
                                <i class="fas fa-caret-right nav-icon"></i>
                                <p>Client Say</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="{{ url('admin/music-sports/menu') }}" class="nav-link {{ (isset($menu)&&$menu=='music_sports')?'active':'' }}">
                        <i class="nav-icon fas fa-medal"></i>
                        <p>Music+Sports Awards</p>
                    </a>
                </li>
            
                <!--<li class="nav-item has-treeview ">-->
                <!--    <a href="#" class="nav-link {{ (isset($menu)&&$menu=='dr_tv')?'active':'' }}">-->
                <!--        <i class="nav-icon fas fa-medal"></i>-->
                <!--        <p>-->
                <!--           Drtv-->
                <!--            <i class="right fas fa-angle-left"></i>-->
                <!--        </p>-->
                <!--    </a>-->
                <!--    <ul class="nav nav-treeview">-->
                <!--        <li class="nav-item">-->
                <!--            <a href="{{route('about.drtv')}}"class="nav-link">-->
                <!--                <i class="fas fa-caret-right nav-icon"></i>-->
                <!--                <p>About DrTv</p>-->
                <!--            </a>-->
                <!--        </li>-->
                <!--         <li class="nav-item">-->
                <!--            <a href="{{route('drtv.team')}}"class="nav-link">-->
                <!--                <i class="fas fa-caret-right nav-icon"></i>-->
                <!--                <p>DrTv Composer team</p>-->
                <!--            </a>-->
                <!--        </li>-->
                <!--      <li class="nav-item">-->
                <!--    <a href="{{ url('admin/dr-tv') }}" class="nav-link {{ (isset($menu)&&$menu=='dr_tv')?'active':'' }}">-->
                <!--        <i class="nav-icon fas fa-caret-right"></i>-->
                <!--        <p>Artist List</p>-->
                <!--    </a>-->
                <!--</li>-->
                <!--<li class="nav-item">-->
                <!--            <a href="{{route('drtv.part')}}"class="nav-link">-->
                <!--                <i class="fas fa-caret-right nav-icon"></i>-->
                <!--                <p>DrTv Partnership</p>-->
                <!--            </a>-->
                <!--        </li>-->
                <!--    </ul>-->
                <!--</li>-->
                    <li class="nav-item has-treeview {{ (isset($menu)&&$menu=='dr_tv')?'menu-open':'' }}">
                    <a href="#" class="nav-link {{ (isset($menu)&&$menu=='dr_tv')?'active':'' }}">
                        <i class="nav-icon fa fa-question"></i>
                        <p>
                            DR TV
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                       {{--  <li class="nav-item">
                            <a href="{{route('about.drtv')}}" class="nav-link {{ (isset($sub_menu)&&$sub_menu=='about_drtv')?'active':'' }}">
                                <i class="fas fa-caret-right nav-icon"></i>
                                <p>About DrTv</p>
                            </a>
                        </li> --}}
                        <li class="nav-item">
                            <a href="{{ url('admin/seo-show?seo_menu=dr_tv&main_menu=dr_tv&sub_menu=team&section=header') }}" class="nav-link {{ (isset($sub_menu)&&$sub_menu=='team')?'active':'' }}">
                                <i class="fas fa-caret-right nav-icon"></i>
                                <p>Composer team</p>
                            </a>
                        </li>
                        <!--<li class="nav-item">-->
                        <!--    <a href="{{route('drtv.team')}}" class="nav-link {{ (isset($sub_menu)&&$sub_menu=='drtv_team')?'active':'' }}">-->
                        <!--        <i class="fas fa-caret-right nav-icon"></i>-->
                        <!--        <p>DrTv Composer team</p>-->
                        <!--    </a>-->
                        <!--</li>-->
                        <li class="nav-item">
                            <a href="{{ url('admin/dr-tv') }}" class="nav-link {{ (isset($sub_menu)&&$sub_menu=='drtv_artist_list')?'active':'' }}">
                                <i class="fas fa-caret-right nav-icon"></i>
                                <p>Artist List</p>
                            </a>
                        </li>
                        {{--  <li class="nav-item">
                            <a href="{{route('drtv.part')}}" class="nav-link {{ (isset($sub_menu)&&$sub_menu=='drtv_pratner')?'active':'' }}">
                                <i class="fas fa-caret-right nav-icon"></i>
                                <p>DrTv Partnership</p>
                            </a>
                        </li> --}}
                        <li class="nav-item">
                            <a href="{{ url('admin/seo-show?seo_menu=dr_tv&main_menu=dr_tv&sub_menu=dr_music&section=footer') }}" class="nav-link {{ (isset($sub_menu)&&$sub_menu=='dr_music')?'active':'' }}">
                                <i class="fas fa-caret-right nav-icon"></i>
                                <p>DrTv Music</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="{{ url('admin/submit-music') }}" class="nav-link {{ (isset($menu)&&$menu=='submit_music')?'active':'' }}">
                        <i class="nav-icon fa fa-music"></i>
                        <p>Submit Music</p>
                    </a>
                </li>
                <li class="nav-item has-treeview {{ (isset($menu)&&$menu=='news')?'menu-open':'' }}">
                    <a href="#" class="nav-link {{ (isset($menu)&&$menu=='news')?'active':'' }}">
                        <i class="nav-icon fa fa-newspaper"></i>
                        <p>
                            News
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ url('admin/news-list') }}" class="nav-link {{ (isset($sub_menu)&&$sub_menu=='news_list')?'active':'' }}">
                                <i class="fas fa-caret-right nav-icon"></i>
                                <p>News List</p>
                            </a>
                        </li>
                        <!--<li class="nav-item">-->
                        <!--    <a href="{{url('admin/news-create')}}" class="nav-link {{ (isset($sub_menu)&&$sub_menu=='news_create')?'active':'' }}">-->
                        <!--        <i class="fas fa-caret-right nav-icon"></i>-->
                        <!--        <p>Create News</p>-->
                        <!--    </a>-->
                        <!--</li>-->
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="{{ url('admin/new-album') }}" class="nav-link {{ (isset($menu)&&$menu=='new_album')?'active':'' }}">
                        <i class="nav-icon fa fa-record-vinyl"></i>
                        <p>New Album</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('admin/site-settings') }}" class="nav-link {{ (isset($menu)&&$menu=='site_settings')?'active':'' }}">
                        <i class="nav-icon fa fa-tools"></i>
                        <p>Site Settings</p>
                    </a>
                </li>
                @endif
                @if(Auth::user()->level == 1 || Auth::user()->level == 2)
                <li class="nav-item has-treeview {{ (isset($menu)&&$menu=='seo')?'menu-open':'' }}">
                    <a href="#" class="nav-link {{ (isset($menu)&&$menu=='seo')?'active':'' }}">
                        <i class="nav-icon fas fa-globe"></i>
                        <p>
                            SEO
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        
                        @if(isset($seos))
                        @foreach($seos as $seo)
                        <li class="nav-item">
                            <a href="{{ url('admin/seo-show?seo_menu=' . $seo->menu_name) }}" class="nav-link {{ (isset($sub_menu)&&$sub_menu==$seo->menu_name)?'active':'' }}">
                                <i class="fas fa-caret-right nav-icon"></i>
                                <p>{{ $seo->menu_title }}</p>
                            </a>
                        </li>
                        @endforeach
                        @endif
                    </ul>
                </li>
                @endif
                <li class="nav-item">
                    <a href="{{ url('admin/change-password') }}" class="nav-link {{ (isset($menu)&&$menu=='change_password')?'active':'' }}">
                        <i class="nav-icon fa fa-tools"></i>
                        <p>Change Password</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link"
                        onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt"></i>
                        <p>Logout</p>
                    </a>
                    <form id="logout-form" action="{{ url('admin/logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
<!-- /.Main Sidebar Container