# Verwendung
Der erste Befehl lädt das Skript script.sh von der angegebenen URL herunter und führt es aus.
Der zweite Befehl macht dasselbe wie der erste, bietet aber zusätzlich die Option, das Flex Recipe durch Angabe von --reset zurückzusetzen.

```bash
curl -s https://raw.githubusercontent.com/KruseMedienGmbH/krme-code-quality-meta/main/script.sh | bash
```

```bash
curl -s https://raw.githubusercontent.com/KruseMedienGmbH/krme-code-quality-meta/main/script.sh | bash -s -- --reset
```