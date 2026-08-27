<?php

namespace DRContacts\form;

class Form
{
	/**
	 * Girdideki zararlı HTML ve script etiketlerini temizler (XSS Koruması).
	 *
	 * @param string $value
	 * @return string
	 */
	public static function clean(string $value): string
	{
		$value = trim($value);
		return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
	}
	public static function valid($value)
	{
		if (preg_match("#^[a-zA-Z0-9\.\-ÖÇŞİĞÜöçşiğüı@]+$#u", $value)) {
			return $value;
		} else {
			header("Refresh: 5; url=http://" . $_SERVER["HTTP_HOST"] . "/");
			die("<center>Kullanici adi veya sifre yanlis !!!<br />Anasayfa'ya yönlendiriliyorsunuz.</center>");
		}
	}

	/**
	 * E-posta adresinin gerçek bir e-posta formatında olup olmadığını doğrular.
	 *
	 * @param string $value
	 * @return bool
	 */
	public static function isValidEmail(string $value): bool
	{
		return (bool) filter_var($value, FILTER_VALIDATE_EMAIL);
	}
	/**
	 * Telefon numarası formatını doğrular (Örn: Sadece rakamlar ve en az 10 karakter).
	 *
	 * @param string $value
	 * @return bool
	 */
	public static function isValidPhone(string $value): bool
	{
		// Boşlukları ve parantezleri temizleyip kontrol edebilirsiniz
		$cleanPhone = preg_replace('/\D/', '', $value);
		return strlen($cleanPhone) >= 10 && strlen($cleanPhone) <= 15;
	}
}
