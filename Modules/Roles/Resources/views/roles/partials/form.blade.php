<!-- ============================
     PERMISSIONS PAGE (FULL BLADE)
     ============================ -->

<!-- تحميل bootstrap-select CSS -->
<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta3/css/bootstrap-select.min.css">

<style>
    .permission-card {
        background: #f8f9fc;
        border: 1px solid #d6d8e1;
        border-radius: 6px;
        padding: 20px;
        margin-bottom: 25px;
    }

    .bootstrap-select .dropdown-menu {
        max-height: 250px !important;
    }

    .bootstrap-select .dropdown-menu.inner {
        max-height: 200px !important;
    }
</style>


<div class="form-group col-12">
    <h4 class="mb-4">الصلاحيات</h4>
{{ BsForm::text('name')->required() }}

    @php
        $config = config('laratrust_seeder.roles_structure.super_admin');
        $mapPermission = collect(config('laratrust_seeder.permissions_map'));
    @endphp

    @foreach ($config as $modelKey => $permissionsString)

        <div class="permission-card">

            <label class="font-weight-bold" style="font-size:16px;">
                @lang('roles::roles.models.' . $modelKey)
            </label>

            @php
                $permissions = explode(',', $permissionsString);
                $selected = [];

                if (isset($role)) {
                    foreach ($permissions as $permKey) {
                        $perm = $mapPermission->get($permKey) . '_' . $modelKey;

                        if ($role->hasPermission($perm)) {
                            $selected[] = $perm;
                        }
                    }
                }
            @endphp

            <select
                name="permissions[]"
                class="selectpicker form-control"
                multiple
                data-live-search="true"
                data-actions-box="true"
                data-size="6"
                title="لم يتم اختيار شيء">

                @foreach ($permissions as $permKey)
                    @php
                        $value = $mapPermission->get($permKey).'_'.$modelKey;
                    @endphp

                    <option value="{{ $value }}"
                            @if(in_array($value, $selected)) selected @endif>
                        @lang('roles::roles.permission_maps.' . $mapPermission->get($permKey))
                    </option>
                @endforeach

            </select>
        </div>

    @endforeach
</div>



<!-- تحميل bootstrap-select JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta3/js/bootstrap-select.min.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        $('.selectpicker').selectpicker();
    });
</script>
