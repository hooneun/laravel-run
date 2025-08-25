# 02. 사용자 인증 시스템 확장

## 🎯 목표
기존 Laravel Breeze 인증을 BookmarkHub에 맞게 확장하여 사용자 프로필 정보와 소셜 기능을 위한 기본 구조를 구축합니다.

## 📋 요구사항
### 기능적 요구사항
- 사용자 회원가입/로그인 기능 (기존)
- 사용자 프로필 확장 (username, bio, avatar)
- 이메일 인증 기능
- 비밀번호 재설정 기능
- 프로필 수정 기능

### 기술적 요구사항
- Laravel Sanctum 인증
- 파일 업로드 (아바타)
- 유효성 검증 규칙
- 프로필 이미지 최적화

## 🛠️ 구현 사항

### Backend
- [ ] User 모델 확장
  ```php
  // app/Models/User.php
  - username (unique, 3-20자)
  - bio (nullable, 500자 제한)
  - avatar (nullable, 이미지 파일 경로)
  - email_verified_at
  - following_count (default: 0)
  - followers_count (default: 0)
  - bookmarks_count (default: 0)
  ```

- [ ] 데이터베이스 마이그레이션 생성
  ```bash
  php artisan make:migration add_profile_fields_to_users_table
  ```

- [ ] 프로필 컨트롤러 생성
  ```php
  // app/Http/Controllers/ProfileController.php
  - show() - 프로필 보기
  - edit() - 프로필 수정 폼
  - update() - 프로필 업데이트
  - uploadAvatar() - 아바타 업로드
  ```

- [ ] 폼 요청 검증 클래스 생성
  ```php
  // app/Http/Requests/UpdateProfileRequest.php
  - username 유효성 검증 (중복 체크)
  - bio 길이 제한 검증
  - avatar 파일 형식 검증 (jpg, png, gif, 2MB 제한)
  ```

- [ ] 아바타 저장 서비스 클래스 생성
  ```php
  // app/Services/AvatarService.php
  - 이미지 리사이징 (150x150 썸네일)
  - 기존 아바타 삭제
  ```

### Frontend
- [ ] 사용자 타입 정의 확장
  ```typescript
  // resources/js/types/index.ts
  interface User {
    id: number;
    name: string;
    email: string;
    username: string;
    bio?: string;
    avatar?: string;
    email_verified_at?: string;
    following_count: number;
    followers_count: number;
    bookmarks_count: number;
  }
  ```

- [ ] 프로필 페이지 컴포넌트 생성
  ```tsx
  // resources/js/pages/profile/show.tsx
  - 사용자 정보 표시
  - 아바타 이미지
  - 팔로우 통계
  - 북마크 통계
  ```

- [ ] 프로필 수정 페이지 컴포넌트
  ```tsx
  // resources/js/pages/profile/edit.tsx
  - 프로필 수정 폼
  - 아바타 업로드 UI
  - 실시간 유효성 검증
  ```

- [ ] 아바타 컴포넌트 생성
  ```tsx
  // resources/js/components/Avatar.tsx
  - 아바타 이미지 표시
  - 기본 아바타 fallback
  - 다양한 크기 지원
  ```

## 📁 파일 구조
```
app/
├── Http/
│   ├── Controllers/
│   │   └── ProfileController.php
│   └── Requests/
│       └── UpdateProfileRequest.php
├── Models/
│   └── User.php (수정)
└── Services/
    └── AvatarService.php

database/
└── migrations/
    └── xxxx_add_profile_fields_to_users_table.php

resources/js/
├── components/
│   ├── Avatar.tsx
│   └── ui/ (기존)
├── pages/
│   ├── profile/
│   │   ├── show.tsx
│   │   └── edit.tsx
│   └── auth/ (기존)
└── types/
    └── index.ts (수정)

routes/
├── web.php (프로필 라우트 추가)
└── auth.php (기존)

public/
└── storage/
    └── avatars/ (심볼릭 링크)
```

## ✅ 완료 기준
- [ ] 사용자 회원가입 시 username 필드 입력 가능
- [ ] 프로필 페이지에서 사용자 정보 조회 가능
- [ ] 프로필 수정 페이지에서 정보 업데이트 가능
- [ ] 아바타 이미지 업로드 및 표시 기능
- [ ] username 중복 체크 기능
- [ ] 이메일 인증 메일 발송 기능
- [ ] 모든 폼에 적절한 유효성 검증 적용
- [ ] 반응형 UI 구현

## 🧪 테스트
### Backend 테스트
- [ ] 사용자 프로필 업데이트 테스트
- [ ] 아바타 업로드 테스트
- [ ] Username 중복 검증 테스트
- [ ] 폼 유효성 검증 테스트

### Frontend 테스트  
- [ ] 프로필 페이지 렌더링 테스트
- [ ] 아바타 업로드 UI 테스트
- [ ] 폼 제출 기능 테스트
- [ ] 반응형 레이아웃 테스트

### 수동 테스트
- [ ] 사용자 회원가입 전체 플로우
- [ ] 프로필 수정 전체 플로우
- [ ] 아바타 업로드/변경 플로우
- [ ] 이메일 인증 플로우

## 📚 참고자료
- [Laravel File Storage](https://laravel.com/docs/11.x/filesystem)
- [Laravel Validation](https://laravel.com/docs/11.x/validation)
- [Laravel Image Intervention](https://image.intervention.io/v2)
- [React Hook Form](https://react-hook-form.com/)

---
**상태**: 📝 계획  
**예상 소요 시간**: 3-4일  
**담당자**: 백엔드/프론트엔드 개발팀  
**우선순위**: 높음  
**의존성**: 01-project-setup.md
