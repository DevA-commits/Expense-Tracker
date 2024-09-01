export class FileUpload {
    /**
     * request
     * @param {*} url
     * @param {*} method
     * @param {*} data
     * @returns
     */
    request(url, method, data) {
        const ajax = $.ajax({
            url: url,
            method: method,
            data: data,
            dataType: "json",
            contentType: false,
            processData: false,
            cache: false,
        });

        return ajax;
    }
}
