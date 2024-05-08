@php
    use App\Models\User;
@endphp


<aside class="sidebar-wrapper" data-simplebar="true">
    <div class="sidebar-header">
      <div>
        <img src="{{ asset('admin_assets/images/logo-icon.png')}}" class="logo-icon" alt="logo icon">
      </div>
      <div>
        <h4 class="logo-text">Snacked</h4>
      </div>
      <div class="toggle-icon ms-auto"> <i class="bi bi-list"></i>
      </div>
    </div>
    <!--navigation-->
    <ul class="metismenu" id="menu">
      <li>
        <a href="javascript:;">
          <div class="parent-icon"><i class="bi bi-house-fill"></i>
          </div>
          <div class="menu-title">@lang('dashboard')</div>
        </a>
      </li>
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
             الاستحقاق المالي للموزعين            </a>
            </li>
        </ul>
      </li>
      @endif



    </ul>
    <!--end navigation-->
 </aside>
