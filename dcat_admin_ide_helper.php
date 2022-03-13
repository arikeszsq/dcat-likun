<?php

/**
 * A helper file for Dcat Admin, to provide autocomplete information to your IDE
 *
 * This file should not be included in your code, only analyzed by your IDE!
 *
 * @author jqh <841324345@qq.com>
 */
namespace Dcat\Admin {
    use Illuminate\Support\Collection;

    /**
     * @property Grid\Column|Collection id
     * @property Grid\Column|Collection name
     * @property Grid\Column|Collection type
     * @property Grid\Column|Collection version
     * @property Grid\Column|Collection detail
     * @property Grid\Column|Collection created_at
     * @property Grid\Column|Collection updated_at
     * @property Grid\Column|Collection is_enabled
     * @property Grid\Column|Collection parent_id
     * @property Grid\Column|Collection order
     * @property Grid\Column|Collection icon
     * @property Grid\Column|Collection uri
     * @property Grid\Column|Collection extension
     * @property Grid\Column|Collection permission_id
     * @property Grid\Column|Collection menu_id
     * @property Grid\Column|Collection slug
     * @property Grid\Column|Collection http_method
     * @property Grid\Column|Collection http_path
     * @property Grid\Column|Collection role_id
     * @property Grid\Column|Collection user_id
     * @property Grid\Column|Collection value
     * @property Grid\Column|Collection username
     * @property Grid\Column|Collection password
     * @property Grid\Column|Collection avatar
     * @property Grid\Column|Collection remember_token
     * @property Grid\Column|Collection admin_role_id
     * @property Grid\Column|Collection is_web_super
     * @property Grid\Column|Collection web_id
     * @property Grid\Column|Collection web_name
     * @property Grid\Column|Collection area_id
     * @property Grid\Column|Collection part_id
     * @property Grid\Column|Collection job_role_id
     * @property Grid\Column|Collection connection
     * @property Grid\Column|Collection queue
     * @property Grid\Column|Collection payload
     * @property Grid\Column|Collection exception
     * @property Grid\Column|Collection failed_at
     * @property Grid\Column|Collection excel_user_name
     * @property Grid\Column|Collection excel_user_id
     * @property Grid\Column|Collection mobile
     * @property Grid\Column|Collection talk_time
     * @property Grid\Column|Collection record_url
     * @property Grid\Column|Collection table_name
     * @property Grid\Column|Collection banner
     * @property Grid\Column|Collection code_bg_img
     * @property Grid\Column|Collection bak
     * @property Grid\Column|Collection option_id
     * @property Grid\Column|Collection scan_to_url
     * @property Grid\Column|Collection qcode_pic
     * @property Grid\Column|Collection qcode_pic_has_bg
     * @property Grid\Column|Collection master_id
     * @property Grid\Column|Collection company_name
     * @property Grid\Column|Collection user_name
     * @property Grid\Column|Collection status
     * @property Grid\Column|Collection call_no
     * @property Grid\Column|Collection master_Id
     * @property Grid\Column|Collection wechat
     * @property Grid\Column|Collection qq
     * @property Grid\Column|Collection content
     * @property Grid\Column|Collection part_user_id
     * @property Grid\Column|Collection rolling
     * @property Grid\Column|Collection valid_phone
     * @property Grid\Column|Collection protect_day
     * @property Grid\Column|Collection protect_week
     * @property Grid\Column|Collection protect_month
     * @property Grid\Column|Collection email
     * @property Grid\Column|Collection token
     * @property Grid\Column|Collection email_verified_at
     *
     * @method Grid\Column|Collection id(string $label = null)
     * @method Grid\Column|Collection name(string $label = null)
     * @method Grid\Column|Collection type(string $label = null)
     * @method Grid\Column|Collection version(string $label = null)
     * @method Grid\Column|Collection detail(string $label = null)
     * @method Grid\Column|Collection created_at(string $label = null)
     * @method Grid\Column|Collection updated_at(string $label = null)
     * @method Grid\Column|Collection is_enabled(string $label = null)
     * @method Grid\Column|Collection parent_id(string $label = null)
     * @method Grid\Column|Collection order(string $label = null)
     * @method Grid\Column|Collection icon(string $label = null)
     * @method Grid\Column|Collection uri(string $label = null)
     * @method Grid\Column|Collection extension(string $label = null)
     * @method Grid\Column|Collection permission_id(string $label = null)
     * @method Grid\Column|Collection menu_id(string $label = null)
     * @method Grid\Column|Collection slug(string $label = null)
     * @method Grid\Column|Collection http_method(string $label = null)
     * @method Grid\Column|Collection http_path(string $label = null)
     * @method Grid\Column|Collection role_id(string $label = null)
     * @method Grid\Column|Collection user_id(string $label = null)
     * @method Grid\Column|Collection value(string $label = null)
     * @method Grid\Column|Collection username(string $label = null)
     * @method Grid\Column|Collection password(string $label = null)
     * @method Grid\Column|Collection avatar(string $label = null)
     * @method Grid\Column|Collection remember_token(string $label = null)
     * @method Grid\Column|Collection admin_role_id(string $label = null)
     * @method Grid\Column|Collection is_web_super(string $label = null)
     * @method Grid\Column|Collection web_id(string $label = null)
     * @method Grid\Column|Collection web_name(string $label = null)
     * @method Grid\Column|Collection area_id(string $label = null)
     * @method Grid\Column|Collection part_id(string $label = null)
     * @method Grid\Column|Collection job_role_id(string $label = null)
     * @method Grid\Column|Collection connection(string $label = null)
     * @method Grid\Column|Collection queue(string $label = null)
     * @method Grid\Column|Collection payload(string $label = null)
     * @method Grid\Column|Collection exception(string $label = null)
     * @method Grid\Column|Collection failed_at(string $label = null)
     * @method Grid\Column|Collection excel_user_name(string $label = null)
     * @method Grid\Column|Collection excel_user_id(string $label = null)
     * @method Grid\Column|Collection mobile(string $label = null)
     * @method Grid\Column|Collection talk_time(string $label = null)
     * @method Grid\Column|Collection record_url(string $label = null)
     * @method Grid\Column|Collection table_name(string $label = null)
     * @method Grid\Column|Collection banner(string $label = null)
     * @method Grid\Column|Collection code_bg_img(string $label = null)
     * @method Grid\Column|Collection bak(string $label = null)
     * @method Grid\Column|Collection option_id(string $label = null)
     * @method Grid\Column|Collection scan_to_url(string $label = null)
     * @method Grid\Column|Collection qcode_pic(string $label = null)
     * @method Grid\Column|Collection qcode_pic_has_bg(string $label = null)
     * @method Grid\Column|Collection master_id(string $label = null)
     * @method Grid\Column|Collection company_name(string $label = null)
     * @method Grid\Column|Collection user_name(string $label = null)
     * @method Grid\Column|Collection status(string $label = null)
     * @method Grid\Column|Collection call_no(string $label = null)
     * @method Grid\Column|Collection master_Id(string $label = null)
     * @method Grid\Column|Collection wechat(string $label = null)
     * @method Grid\Column|Collection qq(string $label = null)
     * @method Grid\Column|Collection content(string $label = null)
     * @method Grid\Column|Collection part_user_id(string $label = null)
     * @method Grid\Column|Collection rolling(string $label = null)
     * @method Grid\Column|Collection valid_phone(string $label = null)
     * @method Grid\Column|Collection protect_day(string $label = null)
     * @method Grid\Column|Collection protect_week(string $label = null)
     * @method Grid\Column|Collection protect_month(string $label = null)
     * @method Grid\Column|Collection email(string $label = null)
     * @method Grid\Column|Collection token(string $label = null)
     * @method Grid\Column|Collection email_verified_at(string $label = null)
     */
    class Grid {}

    class MiniGrid extends Grid {}

    /**
     * @property Show\Field|Collection id
     * @property Show\Field|Collection name
     * @property Show\Field|Collection type
     * @property Show\Field|Collection version
     * @property Show\Field|Collection detail
     * @property Show\Field|Collection created_at
     * @property Show\Field|Collection updated_at
     * @property Show\Field|Collection is_enabled
     * @property Show\Field|Collection parent_id
     * @property Show\Field|Collection order
     * @property Show\Field|Collection icon
     * @property Show\Field|Collection uri
     * @property Show\Field|Collection extension
     * @property Show\Field|Collection permission_id
     * @property Show\Field|Collection menu_id
     * @property Show\Field|Collection slug
     * @property Show\Field|Collection http_method
     * @property Show\Field|Collection http_path
     * @property Show\Field|Collection role_id
     * @property Show\Field|Collection user_id
     * @property Show\Field|Collection value
     * @property Show\Field|Collection username
     * @property Show\Field|Collection password
     * @property Show\Field|Collection avatar
     * @property Show\Field|Collection remember_token
     * @property Show\Field|Collection admin_role_id
     * @property Show\Field|Collection is_web_super
     * @property Show\Field|Collection web_id
     * @property Show\Field|Collection web_name
     * @property Show\Field|Collection area_id
     * @property Show\Field|Collection part_id
     * @property Show\Field|Collection job_role_id
     * @property Show\Field|Collection connection
     * @property Show\Field|Collection queue
     * @property Show\Field|Collection payload
     * @property Show\Field|Collection exception
     * @property Show\Field|Collection failed_at
     * @property Show\Field|Collection excel_user_name
     * @property Show\Field|Collection excel_user_id
     * @property Show\Field|Collection mobile
     * @property Show\Field|Collection talk_time
     * @property Show\Field|Collection record_url
     * @property Show\Field|Collection table_name
     * @property Show\Field|Collection banner
     * @property Show\Field|Collection code_bg_img
     * @property Show\Field|Collection bak
     * @property Show\Field|Collection option_id
     * @property Show\Field|Collection scan_to_url
     * @property Show\Field|Collection qcode_pic
     * @property Show\Field|Collection qcode_pic_has_bg
     * @property Show\Field|Collection master_id
     * @property Show\Field|Collection company_name
     * @property Show\Field|Collection user_name
     * @property Show\Field|Collection status
     * @property Show\Field|Collection call_no
     * @property Show\Field|Collection master_Id
     * @property Show\Field|Collection wechat
     * @property Show\Field|Collection qq
     * @property Show\Field|Collection content
     * @property Show\Field|Collection part_user_id
     * @property Show\Field|Collection rolling
     * @property Show\Field|Collection valid_phone
     * @property Show\Field|Collection protect_day
     * @property Show\Field|Collection protect_week
     * @property Show\Field|Collection protect_month
     * @property Show\Field|Collection email
     * @property Show\Field|Collection token
     * @property Show\Field|Collection email_verified_at
     *
     * @method Show\Field|Collection id(string $label = null)
     * @method Show\Field|Collection name(string $label = null)
     * @method Show\Field|Collection type(string $label = null)
     * @method Show\Field|Collection version(string $label = null)
     * @method Show\Field|Collection detail(string $label = null)
     * @method Show\Field|Collection created_at(string $label = null)
     * @method Show\Field|Collection updated_at(string $label = null)
     * @method Show\Field|Collection is_enabled(string $label = null)
     * @method Show\Field|Collection parent_id(string $label = null)
     * @method Show\Field|Collection order(string $label = null)
     * @method Show\Field|Collection icon(string $label = null)
     * @method Show\Field|Collection uri(string $label = null)
     * @method Show\Field|Collection extension(string $label = null)
     * @method Show\Field|Collection permission_id(string $label = null)
     * @method Show\Field|Collection menu_id(string $label = null)
     * @method Show\Field|Collection slug(string $label = null)
     * @method Show\Field|Collection http_method(string $label = null)
     * @method Show\Field|Collection http_path(string $label = null)
     * @method Show\Field|Collection role_id(string $label = null)
     * @method Show\Field|Collection user_id(string $label = null)
     * @method Show\Field|Collection value(string $label = null)
     * @method Show\Field|Collection username(string $label = null)
     * @method Show\Field|Collection password(string $label = null)
     * @method Show\Field|Collection avatar(string $label = null)
     * @method Show\Field|Collection remember_token(string $label = null)
     * @method Show\Field|Collection admin_role_id(string $label = null)
     * @method Show\Field|Collection is_web_super(string $label = null)
     * @method Show\Field|Collection web_id(string $label = null)
     * @method Show\Field|Collection web_name(string $label = null)
     * @method Show\Field|Collection area_id(string $label = null)
     * @method Show\Field|Collection part_id(string $label = null)
     * @method Show\Field|Collection job_role_id(string $label = null)
     * @method Show\Field|Collection connection(string $label = null)
     * @method Show\Field|Collection queue(string $label = null)
     * @method Show\Field|Collection payload(string $label = null)
     * @method Show\Field|Collection exception(string $label = null)
     * @method Show\Field|Collection failed_at(string $label = null)
     * @method Show\Field|Collection excel_user_name(string $label = null)
     * @method Show\Field|Collection excel_user_id(string $label = null)
     * @method Show\Field|Collection mobile(string $label = null)
     * @method Show\Field|Collection talk_time(string $label = null)
     * @method Show\Field|Collection record_url(string $label = null)
     * @method Show\Field|Collection table_name(string $label = null)
     * @method Show\Field|Collection banner(string $label = null)
     * @method Show\Field|Collection code_bg_img(string $label = null)
     * @method Show\Field|Collection bak(string $label = null)
     * @method Show\Field|Collection option_id(string $label = null)
     * @method Show\Field|Collection scan_to_url(string $label = null)
     * @method Show\Field|Collection qcode_pic(string $label = null)
     * @method Show\Field|Collection qcode_pic_has_bg(string $label = null)
     * @method Show\Field|Collection master_id(string $label = null)
     * @method Show\Field|Collection company_name(string $label = null)
     * @method Show\Field|Collection user_name(string $label = null)
     * @method Show\Field|Collection status(string $label = null)
     * @method Show\Field|Collection call_no(string $label = null)
     * @method Show\Field|Collection master_Id(string $label = null)
     * @method Show\Field|Collection wechat(string $label = null)
     * @method Show\Field|Collection qq(string $label = null)
     * @method Show\Field|Collection content(string $label = null)
     * @method Show\Field|Collection part_user_id(string $label = null)
     * @method Show\Field|Collection rolling(string $label = null)
     * @method Show\Field|Collection valid_phone(string $label = null)
     * @method Show\Field|Collection protect_day(string $label = null)
     * @method Show\Field|Collection protect_week(string $label = null)
     * @method Show\Field|Collection protect_month(string $label = null)
     * @method Show\Field|Collection email(string $label = null)
     * @method Show\Field|Collection token(string $label = null)
     * @method Show\Field|Collection email_verified_at(string $label = null)
     */
    class Show {}

    /**
     
     */
    class Form {}

}

namespace Dcat\Admin\Grid {
    /**
     
     */
    class Column {}

    /**
     
     */
    class Filter {}
}

namespace Dcat\Admin\Show {
    /**
     
     */
    class Field {}
}
