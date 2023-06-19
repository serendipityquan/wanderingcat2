define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'mao/info/index' + location.search,
                    add_url: 'mao/info/add',
                    edit_url: 'mao/info/edit',
                    del_url: 'mao/info/del',
                    multi_url: 'mao/info/multi',
                    import_url: 'mao/info/import',
                    table: 'mao_info',
                }
            });

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'id',
                sortName: 'id',
                columns: [
                    [
                        {checkbox: true},
                        {field: 'id', title: __('Id')},
                        {field: 'mao_pic', title: __('Mao_pic'), operate: 'LIKE'},
                        {field: 'wx_pic', title: __('Wx_pic'), operate: 'LIKE'},
                        {field: 'mao_name', title: __('Mao_name'), operate: 'LIKE'},
                        {field: 'mao_age', title: __('Mao_age'), operate: 'LIKE'},
                        {field: 'mao_sex', title: __('Mao_sex'), searchList: {"1":__('Mao_sex 1'),"2":__('Mao_sex 2'),"3":__('Mao_sex 3')}, formatter: Table.api.formatter.normal},
                        {field: 'mao_jy', title: __('Mao_jy'), searchList: {"0":__('Mao_jy 0'),"1":__('Mao_jy 1')}, formatter: Table.api.formatter.normal},
                        {field: 'mao_source', title: __('Mao_source'), operate: 'LIKE'},
                        {field: 'mao_remark', title: __('Mao_remark'), operate: 'LIKE'},
                        {field: 'city', title: __('City'), operate: 'LIKE'},
                        {field: 'province_id', title: __('Province_id')},
                        {field: 'city_id', title: __('City_id')},
                        {field: 'district_id', title: __('District_id')},
                        {field: 'mao_ym', title: __('Mao_ym'), searchList: {"0":__('Mao_ym 0'),"1":__('Mao_ym 1')}, formatter: Table.api.formatter.normal},
                        {field: 'create_time', title: __('Create_time'), operate:'RANGE', addclass:'datetimerange', autocomplete:false, formatter: Table.api.formatter.datetime},
                        {field: 'update_time', title: __('Update_time'), operate:'RANGE', addclass:'datetimerange', autocomplete:false, formatter: Table.api.formatter.datetime},
                        {field: 'uid', title: __('Uid'), operate: 'LIKE'},
                        {field: 'sn', title: __('Sn'), operate: 'LIKE'},
                        {field: 'operate', title: __('Operate'), table: table, events: Table.api.events.operate, formatter: Table.api.formatter.operate}
                    ]
                ]
            });

            // 为表格绑定事件
            Table.api.bindevent(table);
        },
        add: function () {
            Controller.api.bindevent();
        },
        edit: function () {
            Controller.api.bindevent();
        },
        api: {
            bindevent: function () {
                Form.api.bindevent($("form[role=form]"));
            }
        }
    };
    return Controller;
});