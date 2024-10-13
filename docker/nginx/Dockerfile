FROM nginx:1.27.2-alpine-slim

ENV TZ=Europe/Moscow

RUN apk add --no-cache --virtual .deps tzdata=2024b-r0 \
    && ln -snf /usr/share/zoneinfo/${TZ} /etc/localtime && echo ${TZ} > /etc/timezone \
    && rm -rif /tmp/*

COPY ./docker/nginx/templates/default.conf.template /etc/nginx/my.conf
COPY ./docker/nginx/nginx.conf /etc/nginx/nginx.conf

CMD ["nginx", "-g", "daemon off;"]
