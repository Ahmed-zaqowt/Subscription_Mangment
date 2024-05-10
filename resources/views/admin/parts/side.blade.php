@php
    use App\Models\User;
@endphp


<aside class="sidebar-wrapper" data-simplebar="true">
    <div class="sidebar-header">
      <div>
        <img src="{{ asset('admin_assets/images/logo-icon.png')}}" class="logo-icon" alt="logo icon">
      </div>
      <div>
        <h4 class="logo-text">Salhi</h4>
      </div>
      <div class="toggle-icon ms-auto"> <i class="bi bi-list"></i>
      </div>
    </div>
    <!--navigation-->
    <ul class="metismenu" id="menu">

       @if (Auth::user()->status == User::SUPER)
       <li class="menu-label">@lang('admin_tools')</li>
       <li>
         <a class="has-arrow">
           <div class="parent-icon"><i class="lni lni-users"></i>
           </div>
           <div class="menu-title">إدارة الموزعين </div>
         </a>
         <ul>
             <li>
             <a href="{{ route('admin.admin.index') }}">
                 <i class="bi bi-circle"></i>
                 جميع الموزعين
             </a>
             </li>
         </ul>
       </li>
       <li>
         <a class="has-arrow">
           <div class="parent-icon"><i class="lni lni-users"></i>
           </div>
           <div class="menu-title">إدارة الاشتراكات </div>
         </a>
         <ul>
             <li>
                 <a href="{{ route('admin.subscription.index') }}">
                     <i class="bi bi-circle"></i>
                     جميع الاشتراكات
                 </a>
                 </li>

             <li>
             <a href="{{ route('admin.subscription.accepted') }}">
                 <i class="bi bi-circle"></i>
                  الاشتراكات الجارية
             </a>
             </li>

             <li>
                 <a href="{{ route('admin.subscription.expired') }}">
                     <i class="bi bi-circle"></i>
                      الاشتراكات المنتهية
                 </a>
             </li>


         </ul>
       </li>
       <li>
         <a class="has-arrow">
           <div class="parent-icon"><i class="fadeIn animated bx bx-box"></i>
           </div>
           <div class="menu-title">إدارة الطلبات </div>
         </a>
         <ul>
             <li>
             <a href="{{  route('admin.order.index') }}">
                 <i class="bi bi-circle"></i>
                  الطلبات المعلقة
             </a>
             </li>
             <li>
                 <a href="{{  route('admin.order.canceled') }}">
                     <i class="bi bi-circle"></i>
                      الطلبات الملغية
                 </a>
                 </li>
                 <li>
                    <a href="{{  route('admin.order.renewal') }}">
                        <i class="bi bi-circle"></i>
                         الطلبات المرسلة للتجديد
                    </a>
                    </li>
         </ul>
       </li>
       <li>
         <a class="has-arrow">
           <div class="parent-icon"><i class="lni lni-money-location"></i>
           </div>
           <div class="menu-title">الادارة المالية  </div>
         </a>
         <ul>
             <li>
             <a href="{{ route('admin.financial.index') }}">
                 <i class="bi bi-circle"></i>
              الاستحقاق المالي للموزعين            </a>
             </li>
         </ul>
       </li>
       <li>
         <a class="has-arrow">
           <div class="parent-icon"><i class="bi bi-gear-fill"></i>
           </div>
           <div class="menu-title">الاعدادات  </div>
         </a>
         <ul>
             <li>
             <a href="{{ route('admin.setting.index') }}">
                 <i class="bi bi-circle"></i>
                  السعر الشهري للاشتراك
             </a>
             </li>
         </ul>
       </li>
       @endif







      @if (Auth::user()->status == User::ADMIN)
      <li class="menu-label">أدوات الموزع</li>
      <li>
        <a class="has-arrow">
          <div class="parent-icon"><i class="lni lni-users"></i>
          </div>
          <div class="menu-title">إدارة المشتركين </div>
        </a>
        <ul>
            <li>
                <a href="{{ route('dist.user.index') }}">
                    <i class="bi bi-circle"></i>
                    جميع المشتركين
                </a>
                </li>
        </ul>
      </li>
      <li>
        <a class="has-arrow">
          <div class="parent-icon"><i class="lni lni-users"></i>
          </div>
          <div class="menu-title">إدارة الاشتراكات </div>
        </a>
        <ul>
            <li>
                <a href="{{ route('dist.subscription.index') }}">
                    <i class="bi bi-circle"></i>
                    جميع الاشتراكات
                </a>
                </li>

            <li>
            <a href="{{ route('dist.subscription.accepted') }}">
                <i class="bi bi-circle"></i>
                 الاشتراكات الجارية
            </a>
            </li>

            <li>
                <a href="{{ route('dist.subscription.expired') }}">
                    <i class="bi bi-circle"></i>
                     الاشتراكات المنتهية
                </a>
            </li>


        </ul>
      </li>
      <li>
        <a class="has-arrow">
          <div class="parent-icon"><i class="fadeIn animated bx bx-box"></i>
          </div>
          <div class="menu-title">إدارة الطلبات </div>
        </a>
        <ul>
            <li>
            <a href="{{  route('dist.order.index') }}">
                <i class="bi bi-circle"></i>
                 الطلبات المعلقة
            </a>
            </li>
            <li>
                <a href="{{  route('dist.order.canceled') }}">
                    <i class="bi bi-circle"></i>
                     الطلبات الملغية
                </a>
                </li>

                <li>
                    <a href="{{  route('dist.order.renewal') }}">
                        <i class="bi bi-circle"></i>
                         الطلبات المرسلة للتجديد
                    </a>
                    </li>
        </ul>
      </li>
      <li>
        <a class="has-arrow">
          <div class="parent-icon"><i class="lni lni-money-location"></i>
          </div>
          <div class="menu-title">الادارة المالية  </div>
        </a>
        <ul>
            <li>
            <a href="{{ route('dist.financial.index') }}">
                <i class="bi bi-circle"></i>
            المحفظة الخاصة بي           </a>
            </li>
        </ul>
      </li>
      @endif
      <li>
        <a class="has-arrow">
          <div class="parent-icon"><i class="bi bi-person-lines-fill"></i>
          </div>
          <div class="menu-title">ادارة البيانات الشخصية</div>
        </a>
        <ul>
            <li>
            <a href="{{ route('profile.index') }}">
                <i class="bi bi-circle"></i>
                    الملف الشخصي           </a>
            </li>

            <li>
                <a href="{{ route('profile.password') }}">
                    <i class="bi bi-circle"></i>
                        تغيير كلمة المرور          </a>
                </li>
        </ul>
      </li>

      <li>
        <a  onclick="event.preventDefault(); document.getElementById('logout-form').submit()">
          <div class="parent-icon"><i class="bi bi-lock-fill"></i>
          </div>
          <div class="menu-title">تسجيل الخروج</div>
        </a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST">
            @csrf
            {{-- <button class="btn btn-danger btn-block">Logout</button> --}}
           </form>
      </li>


    </ul>
    <!--end navigation-->
 </aside>
