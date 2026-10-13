package com.Jymson.Jymson_Api.Model;

import lombok.Data;
import lombok.NoArgsConstructor;
import lombok.AllArgsConstructor;

@Data
@NoArgsConstructor
@AllArgsConstructor
public class User{
	private Long u_id;
	private String u_name;
	private String u_password;
	private String u_email;
}