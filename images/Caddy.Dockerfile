FROM caddy
COPY images/Caddyfile /etc/caddy/Caddyfile
COPY . /app
