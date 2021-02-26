import env from "../env";
import store from "./store/index"
export default {
    toolbarGroups : [
        { name: 'document', groups: [ 'mode', 'document', 'doctools' ] },
        { name: 'clipboard', groups: [ 'clipboard', 'undo' ] },
        { name: 'editing', groups: [ 'find', 'selection', 'spellchecker', 'editing' ] },
        { name: 'forms', groups: [ 'forms' ] },
        { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
        { name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi', 'paragraph' ] },
        { name: 'links', groups: [ 'links' ] },
        { name: 'insert', groups: [ 'insert' ] },
        { name: 'styles', groups: [ 'styles' ] },
        { name: 'colors', groups: [ 'colors' ] },
        { name: 'tools', groups: [ 'tools' ] },
        { name: 'others', groups: [ 'others' ] },
        { name: 'about', groups: [ 'about' ] }


    ],
    filebrowserUploadUrl:env.API_ADMIN_PATH+'/upload_image?',
    filebrowserUploadMethod:"form",
    extraPlugins: 'uploadimage',
    filebrowserBrowseUrl:env.API_ADMIN_PATH+'/upload_image?',
    withCredentials: true,
    fileTools_requestHeaders:{
        'Authorization':'Bearer '+store.state.auth.token,
        'X-Requested-With': 'XMLHttpRequest',
    }
}
