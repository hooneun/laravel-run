# 🔖 BookmarkHub - URL 북마크 소셜 플랫폼

Laravel 12.x + React + TypeScript를 기반으로 한 현대적인 URL 북마크 관리 및 소셜 플랫폼입니다.

## 🚀 주요 기능

### 📚 북마크 관리
- **URL 북마크 저장**: 웹사이트 URL을 간편하게 저장하고 관리
- **메타데이터 자동 추출**: 제목, 설명, 썸네일 이미지 자동 수집
- **카테고리별 정리**: 사용자 정의 카테고리로 북마크 체계적 관리
- **태그 시스템**: 다중 태그를 통한 유연한 분류 및 검색

### 🔒 프라이버시 설정
- **공개/비공개 설정**: 북마크별 세부 공개 범위 설정
- **카테고리별 프라이버시**: 카테고리 단위로 공개 범위 조절
- **팔로워 전용 공개**: 팔로워에게만 공개되는 북마크 옵션

### 👥 소셜 기능
- **사용자 팔로우/언팔로우**: 관심있는 사용자 팔로우
- **북마크 좋아요 시스템**: 유용한 북마크에 좋아요 표시
- **댓글 시스템**: 북마크에 대한 의견 및 토론
- **공유 기능**: 북마크를 다른 사용자와 쉽게 공유

### 📊 피드 시스템
- **인기 북마크 피드**: 좋아요가 많은 북마크들 모음
- **팔로우 피드**: 팔로우한 사용자들의 최신 북마크
- **카테고리별 트렌딩**: 카테고리별 인기 북마크
- **개인화된 추천**: AI 기반 개인 취향 맞춤 북마크 추천

## 🛠️ 기술 스택

### Backend
- **Laravel 12.x**: PHP 웹 프레임워크
- **PHP 8.2+**: 최신 PHP 버전
- **SQLite**: 개발용 데이터베이스 (MySQL/PostgreSQL 프로덕션 지원)
- **Queue System**: 백그라운드 작업 처리
- **Laravel Sanctum**: API 인증

### Frontend
- **React 19.x**: 최신 React with TypeScript
- **Inertia.js v2**: 서버사이드 렌더링 지원 SPA
- **Tailwind CSS v4**: 유틸리티 우선 CSS 프레임워크
- **shadcn/ui**: 현대적인 UI 컴포넌트 라이브러리
- **Lucide Icons**: 아이콘 시스템

### Development Tools
- **Vite**: 빠른 번들러 및 개발 서버
- **Pest PHP**: 백엔드 테스팅
- **TypeScript**: 타입 안전성
- **ESLint + Prettier**: 코드 품질 및 포매팅

## 📦 설치 및 실행

### 요구사항
- PHP 8.2+
- Node.js 18+
- Composer

### 설치 과정

1. **저장소 클론**
   ```bash
   git clone <repository-url>
   cd laravel-run
   ```

2. **PHP 종속성 설치**
   ```bash
   composer install
   ```

3. **Node.js 종속성 설치**
   ```bash
   npm install
   ```

4. **환경 설정**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **데이터베이스 설정**
   ```bash
   touch database/database.sqlite
   php artisan migrate --seed
   ```

### 개발 서버 실행

**풀스택 개발 서버** (권장)
```bash
composer dev
# Laravel 서버 + Queue Worker + 로그 + Vite를 동시에 실행
```

**개별 서비스 실행**
```bash
php artisan serve                    # Laravel 서버
npm run dev                          # Vite 개발 서버
php artisan queue:listen --tries=1  # Queue 워커
php artisan pail --timeout=0        # 실시간 로그
```

### 테스팅
```bash
composer test        # 백엔드 테스트
npm run lint         # 프론트엔드 린팅
npm run types        # TypeScript 타입 체크
```

## 📁 프로젝트 구조

```
laravel-run/
├── app/
│   ├── Models/              # Eloquent 모델
│   ├── Http/
│   │   ├── Controllers/     # HTTP 컨트롤러
│   │   └── Middleware/      # 미들웨어
│   ├── Services/            # 비즈니스 로직
│   └── Jobs/                # Queue 작업
├── database/
│   ├── migrations/          # 데이터베이스 마이그레이션
│   └── seeders/             # 데이터베이스 시더
├── resources/
│   └── js/
│       ├── pages/           # Inertia 페이지 컴포넌트
│       ├── components/      # React 컴포넌트
│       ├── layouts/         # 레이아웃 컴포넌트
│       └── types/           # TypeScript 타입
├── routes/
│   ├── web.php              # 웹 라우트
│   ├── auth.php             # 인증 라우트
│   └── api.php              # API 라우트
└── tasks/                   # 개발 태스크 문서
```

## 🎯 개발 로드맵

### Phase 1: 기본 북마크 시스템 (2-3주)
- [x] 프로젝트 초기 설정 및 사용자 인증
- [ ] 북마크 CRUD 기능
- [ ] 카테고리 관리 시스템
- [ ] 기본 UI/UX 구현

### Phase 2: 소셜 기능 (2-3주)
- [ ] 사용자 프로필 및 팔로우 시스템
- [ ] 공개/비공개 북마크 설정
- [ ] 좋아요 및 댓글 시스템
- [ ] 사용자 피드 구현

### Phase 3: 고급 기능 (3-4주)
- [ ] 메타데이터 자동 추출
- [ ] 검색 및 필터링
- [ ] 북마크 추천 시스템
- [ ] 알림 시스템

### Phase 4: 최적화 및 확장 (2-3주)
- [ ] 성능 최적화
- [ ] API 개발 (모바일 앱 대비)
- [ ] 관리자 대시보드
- [ ] 배포 및 모니터링 설정

## 📋 주요 엔티티

### User (사용자)
```typescript
interface User {
  id: number;
  name: string;
  email: string;
  username: string;
  avatar?: string;
  bio?: string;
  following_count: number;
  followers_count: number;
  bookmarks_count: number;
}
```

### Bookmark (북마크)
```typescript
interface Bookmark {
  id: number;
  user_id: number;
  url: string;
  title: string;
  description?: string;
  thumbnail?: string;
  is_public: boolean;
  category_id?: number;
  tags: string[];
  likes_count: number;
  comments_count: number;
  created_at: string;
}
```

### Category (카테고리)
```typescript
interface Category {
  id: number;
  user_id: number;
  name: string;
  description?: string;
  color: string;
  is_public: boolean;
  bookmarks_count: number;
}
```

## 🤝 기여하기

1. 이 저장소를 포크합니다
2. 새로운 기능 브랜치를 만듭니다 (`git checkout -b feature/amazing-feature`)
3. 변경사항을 커밋합니다 (`git commit -m 'Add amazing feature'`)
4. 브랜치에 푸시합니다 (`git push origin feature/amazing-feature`)
5. Pull Request를 생성합니다

## 📝 라이선스

이 프로젝트는 MIT 라이선스를 따릅니다. 자세한 내용은 [LICENSE](LICENSE) 파일을 참조하세요.
---

📧 **문의사항**: 프로젝트와 관련된 질문이나 제안사항이 있으시면 Issue를 생성해 주세요.

🌟 **도움이 되셨다면**: 이 프로젝트가 유용하다고 생각하시면 ⭐ Star를 눌러주세요!
