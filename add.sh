#!/bin/bash
connect="mysql -u user -p1 -h localhost data"

echo "Enter text: "
read text

id=$(( $RANDOM % 50 + 1 ))

for ((i=0; i<10; i++))
do
pass=$( openssl rand -base64 3 )
checkPass=$( echo "$pass" | cracklib-check | grep OK | wc -l )
if [[ $checkpass == 1 ]]; then break;else continue; fi
done

hashId=$( echo -n "$id" | openssl dgst -md5 | sed 's|.* ||' )
hashPass=$( echo -n "$pass" | openssl dgst -md5 | sed 's|.* ||' )
cryptoText=$( echo -n $text | openssl enc -aes-256-cbc -a -K 0000 -iv 0000 -nosalt ) # Need change -K and -iv

$(echo "INSERT INTO secret (id, pass, msg) VALUES ('$hashId', '$hashPass', '$cryptoText');" | $connect)

clear

echo "You id: "$id
echo "You hash id: "$hashId
echo "You pass: "$pass
echo "You hashPass: "$hashPass
echo "You text: "$text
echo "You crypto text: "$cryptoText
