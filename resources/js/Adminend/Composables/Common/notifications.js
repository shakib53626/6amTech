import { ElNotification } from 'element-plus'

export function useNotification(){
    const Success = (msg) =>{
        ElNotification({
            title: 'Success',
            message: msg,
            type: 'success',
            position: 'top-left',
        })
    }
    const Warning = (msg) =>{
        ElNotification({
            title: 'Warning',
            message: msg,
            type: 'warning',
            position: 'top-left',
        })
    }
    const Info = (msg) =>{
        ElNotification({
            title: 'Info',
            message: msg,
            type: 'info',
            position: 'top-left',
        })
    }
    const Error = (msg) =>{
        ElNotification({
            title: 'Error',
            message: msg,
            type: 'error',
            position: 'top-left',
        })
    }

    return { Success, Warning, Info, Error }
}
