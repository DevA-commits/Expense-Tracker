export class Server {
    request(url, method, data) {
        const ajax = $.ajax({
            url: url,
            method: method,
            data: data,
            // dataType: "json",
        });

        return ajax;
    }
}
